SELECT 'Upgrading MetaStore schema from 3.2.0 to 4.0.0' AS MESSAGE;

-- HIVE-19416
ALTER TABLE TBLS ADD WRITE_ID bigint NOT NULL CONSTRAINT DEF_TBLS_WRITE_ID DEFAULT(0);
ALTER TABLE PARTITIONS ADD WRITE_ID bigint NOT NULL CONSTRAINT DEF_PARITITIONS_WRITE_ID DEFAULT(0);

-- HIVE-20793
ALTER TABLE WM_RESOURCEPLAN ADD NS nvarchar(128);
UPDATE WM_RESOURCEPLAN SET NS = 'default' WHERE NS IS NULL;
DROP INDEX UNIQUE_WM_RESOURCEPLAN ON WM_RESOURCEPLAN;
CREATE UNIQUE INDEX UNIQUE_WM_RESOURCEPLAN ON WM_RESOURCEPLAN ("NS", "NAME");

-- HIVE-21063
CREATE UNIQUE INDEX NOTIFICATION_LOG_EVENT_ID ON NOTIFICATION_LOG (EVENT_ID);

-- HIVE-21337
ALTER TABLE "COLUMNS_V2" ALTER COLUMN "COMMENT" nvarchar(4000);

-- HIVE-22046 (DEFAULT HIVE)
ALTER TABLE TAB_COL_STATS ADD ENGINE nvarchar(128);
UPDATE TAB_COL_STATS SET ENGINE = 'hive' WHERE ENGINE IS NULL;
ALTER TABLE PART_COL_STATS ADD ENGINE nvarchar(128);
UPDATE PART_COL_STATS SET ENGINE = 'hive' WHERE ENGINE IS NULL;

-- HIVE-22729
ALTER TABLE COMPACTION_QUEUE ADD CQ_ERROR_MESSAGE varchar(max) NULL;
ALTER TABLE COMPLETED_COMPACTIONS ADD CC_ERROR_MESSAGE varchar(max) NULL;

-- HIVE-23683
ALTER TABLE COMPACTION_QUEUE ADD CQ_ENQUEUE_TIME bigint NULL;
ALTER TABLE COMPLETED_COMPACTIONS ADD CC_ENQUEUE_TIME bigint NULL;

-- HIVE-22728
ALTER TABLE KEY_CONSTRAINTS DROP CONSTRAINT CONSTRAINTS_PK;
ALTER TABLE KEY_CONSTRAINTS ADD CONSTRAINT CONSTRAINTS_PK PRIMARY KEY (PARENT_TBL_ID, CONSTRAINT_NAME, POSITION);

-- HIVE-21487
CREATE INDEX COMPLETED_COMPACTIONS_RES ON COMPLETED_COMPACTIONS (CC_DATABASE,CC_TABLE,CC_PARTITION);

CREATE TABLE "SCHEDULED_QUERIES" (
	"SCHEDULED_QUERY_ID"  bigint NOT NULL,
	"CLUSTER_NAMESPACE" VARCHAR(256),
	"ENABLED" bit NOT NULL DEFAULT 0,
	"NEXT_EXECUTION" INTEGER,
	"QUERY" VARCHAR(4000),
	"SCHEDULE" VARCHAR(256),
	"SCHEDULE_NAME" VARCHAR(256),
	"USER" VARCHAR(256),
	"ACTIVE_EXECUTION_ID" bigint,
	CONSTRAINT SCHEDULED_QUERIES_PK PRIMARY KEY ("SCHEDULED_QUERY_ID")
);

CREATE TABLE "SCHEDULED_EXECUTIONS" (
	"SCHEDULED_EXECUTION_ID" bigint NOT NULL,
	"END_TIME" INTEGER,
	"ERROR_MESSAGE" VARCHAR(2000),
	"EXECUTOR_QUERY_ID" VARCHAR(256),
	"LAST_UPDATE_TIME" INTEGER,
	"SCHEDULED_QUERY_ID" bigint,
	"START_TIME" INTEGER,
	"STATE" VARCHAR(256),
	CONSTRAINT SCHEDULED_EXECUTIONS_PK PRIMARY KEY ("SCHEDULED_EXECUTION_ID"),
	CONSTRAINT SCHEDULED_EXECUTIONS_SCHQ_FK FOREIGN KEY ("SCHEDULED_QUERY_ID") REFERENCES "SCHEDULED_QUERIES"("SCHEDULED_QUERY_ID") ON DELETE CASCADE
);

CREATE INDEX IDX_SCHEDULED_EX_LAST_UPDATE ON "SCHEDULED_EXECUTIONS" ("LAST_UPDATE_TIME");
CREATE INDEX IDX_SCHEDULED_EX_SQ_ID ON "SCHEDULED_EXECUTIONS" ("SCHEDULED_QUERY_ID");

-- HIVE-23033
INSERT INTO NOTIFICATION_SEQUENCE (NNI_ID, NEXT_EVENT_ID) SELECT 1,1 WHERE NOT EXISTS (SELECT NEXT_EVENT_ID FROM NOTIFICATION_SEQUENCE);
-- HIVE-22995
ALTER TABLE DBS ADD DB_MANAGED_LOCATION_URI nvarchar(4000);

-- HIVE-23107
ALTER TABLE COMPACTION_QUEUE ADD CQ_NEXT_TXN_ID bigint NOT NULL;

-- HIVE-23048
INSERT INTO TXNS (TXN_ID, TXN_STATE, TXN_STARTED, TXN_LAST_HEARTBEAT, TXN_USER, TXN_HOST)
  SELECT COALESCE(MAX(CTC_TXNID),0), 'c', 0, 0, '', '' FROM COMPLETED_TXN_COMPONENTS;

CREATE TABLE TMP_TXNS(
    TXN_ID bigint NOT NULL IDENTITY(1,1),
    TXN_STATE char(1) NOT NULL,
    TXN_STARTED bigint NOT NULL,
    TXN_LAST_HEARTBEAT bigint NOT NULL,
    TXN_USER nvarchar(128) NOT NULL,
    TXN_HOST nvarchar(128) NOT NULL,
    TXN_AGENT_INFO nvarchar(128) NULL,
    TXN_META_INFO nvarchar(128) NULL,
    TXN_HEARTBEAT_COUNT int NULL,
    TXN_TYPE int NULL,
PRIMARY KEY CLUSTERED
(
   TXN_ID ASC
)
);

SET IDENTITY_INSERT TMP_TXNS ON;
INSERT INTO TMP_TXNS (TXN_ID,TXN_STATE, TXN_STARTED, TXN_LAST_HEARTBEAT, TXN_USER, TXN_HOST, TXN_AGENT_INFO, TXN_META_INFO, TXN_HEARTBEAT_COUNT, TXN_TYPE)
SELECT TXN_ID, TXN_STATE, TXN_STARTED, TXN_LAST_HEARTBEAT, TXN_USER, TXN_HOST, TXN_AGENT_INFO, TXN_META_INFO, TXN_HEARTBEAT_COUNT, TXN_TYPE FROM TXNS TABLOCKX;

SET IDENTITY_INSERT TMP_TXNS OFF;

CREATE TABLE TMP_TXN_COMPONENTS(
    TC_TXNID bigint NOT NULL,
    TC_DATABASE nvarchar(128) NOT NULL,
    TC_TABLE nvarchar(128) NULL,
    TC_PARTITION nvarchar(767) NULL,
    TC_OPERATION_TYPE char(1) NOT NULL,
    TC_WRITEID bigint
);
INSERT INTO TMP_TXN_COMPONENTS SELECT * FROM TXN_COMPONENTS;

DROP TABLE TXN_COMPONENTS;
DROP TABLE TXNS;

Exec sp_rename 'TMP_TXNS', 'TXNS';
Exec sp_rename 'TMP_TXN_COMPONENTS', 'TXN_COMPONENTS';
Exec sp_rename 'NEXT_TXN_ID', 'TXN_LOCK_TBL';
Exec sp_rename 'TXN_LOCK_TBL.NTXN_NEXT', 'TXN_LOCK', 'COLUMN';

ALTER TABLE TXN_COMPONENTS WITH CHECK ADD FOREIGN KEY(TC_TXNID) REFERENCES TXNS (TXN_ID);
CREATE INDEX TC_TXNID_INDEX ON TXN_COMPONENTS (TC_TXNID);

-- HIVE-23516
CREATE TABLE "REPLICATION_METRICS" (
  "RM_SCHEDULED_EXECUTION_ID" bigint PRIMARY KEY,
  "RM_POLICY" varchar(256) NOT NULL,
  "RM_DUMP_EXECUTION_ID" bigint NOT NULL,
  "RM_METADATA" varchar(max),
  "RM_PROGRESS" varchar(max),
  "RM_START_TIME" integer NOT NULL
);

ALTER TABLE "REPLICATION_METRICS" ADD "MESSAGE_FORMAT" VARCHAR(16) DEFAULT 'json-0.2';

-- Create indexes for the replication metrics table
CREATE INDEX "POLICY_IDX" ON "REPLICATION_METRICS" ("RM_POLICY");
CREATE INDEX "DUMP_IDX" ON "REPLICATION_METRICS" ("RM_DUMP_EXECUTION_ID");

-- Create stored procedure tables
CREATE TABLE "STORED_PROCS" (
  "SP_ID" BIGINT NOT NULL,
  "CREATE_TIME" int NOT NULL,
  "DB_ID" BIGINT NOT NULL,
  "NAME" nvarchar(256) NOT NULL,
  "OWNER_NAME" nvarchar(128) NOT NULL,
  "SOURCE" NTEXT NOT NULL,
  PRIMARY KEY ("SP_ID")
);

CREATE UNIQUE INDEX "UNIQUESTOREDPROC" ON "STORED_PROCS" ("NAME", "DB_ID");
ALTER TABLE "STORED_PROCS" ADD CONSTRAINT "STOREDPROC_FK1" FOREIGN KEY ("DB_ID") REFERENCES "DBS" ("DB_ID");

-- Create stored procedure packages
CREATE TABLE "PACKAGES" (
  "PKG_ID" BIGINT NOT NULL,
  "CREATE_TIME" int NOT NULL,
  "DB_ID" BIGINT NOT NULL,
  "NAME" nvarchar(256) NOT NULL,
  "OWNER_NAME" nvarchar(128) NOT NULL,
  "HEADER" NTEXT NOT NULL,
  "BODY" NTEXT NOT NULL,
  PRIMARY KEY ("PKG_ID")
);

CREATE UNIQUE INDEX "UNIQUEPKG" ON "PACKAGES" ("NAME", "DB_ID");
ALTER TABLE "PACKAGES" ADD CONSTRAINT "PACKAGES_FK1" FOREIGN KEY ("DB_ID") REFERENCES "DBS" ("DB_ID");

-- HIVE-24291
ALTER TABLE COMPACTION_QUEUE ADD CQ_TXN_ID bigint NULL;

-- HIVE-24275
ALTER TABLE COMPACTION_QUEUE ADD CQ_COMMIT_TIME bigint NULL;

-- HIVE-24770
UPDATE SERDES SET SLIB='org.apache.hadoop.hive.serde2.MultiDelimitSerDe' where SLIB='org.apache.hadoop.hive.contrib.serde2.MultiDelimitSerDe';

-- HIVE-24880
ALTER TABLE COMPACTION_QUEUE ADD CQ_INITIATOR_ID nvarchar(128) NULL;
ALTER TABLE COMPACTION_QUEUE ADD CQ_INITIATOR_VERSION nvarchar(128) NULL;
ALTER TABLE COMPACTION_QUEUE ADD CQ_WORKER_VERSION nvarchar(128) NULL;
ALTER TABLE COMPLETED_COMPACTIONS ADD CC_INITIATOR_ID nvarchar(128) NULL;
ALTER TABLE COMPLETED_COMPACTIONS ADD CC_INITIATOR_VERSION nvarchar(128) NULL;
ALTER TABLE COMPLETED_COMPACTIONS ADD CC_WORKER_VERSION nvarchar(128) NULL;

-- HIVE-24396
-- Create DataConnectors and DataConnector_Params tables
CREATE TABLE "DATACONNECTORS" (
  "NAME" nvarchar(128) NOT NULL,
  "TYPE" nvarchar(32) NOT NULL,
  "URL" nvarchar(4000) NOT NULL,
  "COMMENT" nvarchar(256),
  "OWNER_NAME" nvarchar(256),
  "OWNER_TYPE" nvarchar(10),
  "CREATE_TIME" int NOT NULL,
  PRIMARY KEY ("NAME")
);
CREATE TABLE "DATACONNECTOR_PARAMS"(
  "NAME" nvarchar(128) NOT NULL,
  "PARAM_KEY" nvarchar(180) NOT NULL,
  "PARAM_VALUE" nvarchar(4000),
  PRIMARY KEY ("NAME", "PARAM_KEY"),
  CONSTRAINT DATACONNECTOR_NAME_FK1 FOREIGN KEY ("NAME") REFERENCES "DATACONNECTORS" ("NAME") ON DELETE CASCADE
);
ALTER TABLE "DBS" ADD "TYPE" nvarchar(32) DEFAULT 'NATIVE' NOT NULL;
ALTER TABLE "DBS" ADD "DATACONNECTOR_NAME" nvarchar(128) NULL;
ALTER TABLE "DBS" ADD "REMOTE_DBNAME" nvarchar(128) NULL;
UPDATE "DBS" SET TYPE='NATIVE' WHERE TYPE IS NULL;

CREATE TABLE DC_PRIVS
(
    DC_GRANT_ID bigint NOT NULL,
    CREATE_TIME int NOT NULL,
    NAME nvarchar(128) NULL,
    GRANT_OPTION smallint NOT NULL CHECK (GRANT_OPTION IN (0,1)),
    GRANTOR nvarchar(128) NULL,
    GRANTOR_TYPE nvarchar(128) NULL,
    PRINCIPAL_NAME nvarchar(128) NULL,
    PRINCIPAL_TYPE nvarchar(128) NULL,
    DC_PRIV nvarchar(128) NULL,
    AUTHORIZER nvarchar(128) NULL
);

ALTER TABLE DC_PRIVS ADD CONSTRAINT DC_PRIVS_PK PRIMARY KEY (DC_GRANT_ID);
ALTER TABLE DC_PRIVS ADD CONSTRAINT DC_PRIVS_FK1 FOREIGN KEY (NAME) REFERENCES DATACONNECTORS (NAME) ;
CREATE UNIQUE INDEX DCPRIVILEGEINDEX ON DC_PRIVS (AUTHORIZER,NAME,PRINCIPAL_NAME,PRINCIPAL_TYPE,DC_PRIV,GRANTOR,GRANTOR_TYPE);
CREATE INDEX DC_PRIVS_N49 ON DC_PRIVS (NAME);

-- HIVE-25656
ALTER TABLE "MV_TABLES_USED" ADD "INSERTED_COUNT" BIGINT NOT NULL DEFAULT 0;
ALTER TABLE "MV_TABLES_USED" ADD "UPDATED_COUNT" BIGINT NOT NULL DEFAULT 0;
ALTER TABLE "MV_TABLES_USED" ADD "DELETED_COUNT" BIGINT NOT NULL DEFAULT 0;
ALTER TABLE "MV_TABLES_USED" ADD CONSTRAINT "MV_TABLES_USED_PK" PRIMARY KEY ("TBL_ID", "MV_CREATION_METADATA_ID");

-- HIVE-25737
ALTER TABLE COMPACTION_QUEUE ADD CQ_CLEANER_START bigint NULL;

-- HIVE-25842
CREATE TABLE COMPACTION_METRICS_CACHE (
    CMC_DATABASE nvarchar(128) NOT NULL,
    CMC_TABLE nvarchar(128) NOT NULL,
    CMC_PARTITION nvarchar(767) NULL,
    CMC_METRIC_TYPE nvarchar(128) NOT NULL,
    CMC_METRIC_VALUE int NOT NULL,
    CMC_VERSION int NOT NULL
);

-- These lines need to be last.  Insert any changes above.
UPDATE VERSION SET SCHEMA_VERSION='4.0.0', VERSION_COMMENT='Hive release version 4.0.0' where VER_ID=1;
SELECT 'Finished upgrading MetaStore schema from 3.2.0 to 4.0.0' AS MESSAGE;
