<?php
namespace metastore;

/**
 * Autogenerated by Thrift Compiler (0.14.1)
 *
 * DO NOT EDIT UNLESS YOU ARE SURE THAT YOU KNOW WHAT YOU ARE DOING
 *  @generated
 */
use Thrift\Base\TBase;
use Thrift\Type\TType;
use Thrift\Type\TMessageType;
use Thrift\Exception\TException;
use Thrift\Exception\TProtocolException;
use Thrift\Protocol\TProtocol;
use Thrift\Protocol\TBinaryProtocolAccelerated;
use Thrift\Exception\TApplicationException;

class SerDeInfo
{
    static public $isValidate = false;

    static public $_TSPEC = array(
        1 => array(
            'var' => 'name',
            'isRequired' => false,
            'type' => TType::STRING,
        ),
        2 => array(
            'var' => 'serializationLib',
            'isRequired' => false,
            'type' => TType::STRING,
        ),
        3 => array(
            'var' => 'parameters',
            'isRequired' => false,
            'type' => TType::MAP,
            'ktype' => TType::STRING,
            'vtype' => TType::STRING,
            'key' => array(
                'type' => TType::STRING,
            ),
            'val' => array(
                'type' => TType::STRING,
                ),
        ),
        4 => array(
            'var' => 'description',
            'isRequired' => false,
            'type' => TType::STRING,
        ),
        5 => array(
            'var' => 'serializerClass',
            'isRequired' => false,
            'type' => TType::STRING,
        ),
        6 => array(
            'var' => 'deserializerClass',
            'isRequired' => false,
            'type' => TType::STRING,
        ),
        7 => array(
            'var' => 'serdeType',
            'isRequired' => false,
            'type' => TType::I32,
            'class' => '\metastore\SerdeType',
        ),
    );

    /**
     * @var string
     */
    public $name = null;
    /**
     * @var string
     */
    public $serializationLib = null;
    /**
     * @var array
     */
    public $parameters = null;
    /**
     * @var string
     */
    public $description = null;
    /**
     * @var string
     */
    public $serializerClass = null;
    /**
     * @var string
     */
    public $deserializerClass = null;
    /**
     * @var int
     */
    public $serdeType = null;

    public function __construct($vals = null)
    {
        if (is_array($vals)) {
            if (isset($vals['name'])) {
                $this->name = $vals['name'];
            }
            if (isset($vals['serializationLib'])) {
                $this->serializationLib = $vals['serializationLib'];
            }
            if (isset($vals['parameters'])) {
                $this->parameters = $vals['parameters'];
            }
            if (isset($vals['description'])) {
                $this->description = $vals['description'];
            }
            if (isset($vals['serializerClass'])) {
                $this->serializerClass = $vals['serializerClass'];
            }
            if (isset($vals['deserializerClass'])) {
                $this->deserializerClass = $vals['deserializerClass'];
            }
            if (isset($vals['serdeType'])) {
                $this->serdeType = $vals['serdeType'];
            }
        }
    }

    public function getName()
    {
        return 'SerDeInfo';
    }


    public function read($input)
    {
        $xfer = 0;
        $fname = null;
        $ftype = 0;
        $fid = 0;
        $xfer += $input->readStructBegin($fname);
        while (true) {
            $xfer += $input->readFieldBegin($fname, $ftype, $fid);
            if ($ftype == TType::STOP) {
                break;
            }
            switch ($fid) {
                case 1:
                    if ($ftype == TType::STRING) {
                        $xfer += $input->readString($this->name);
                    } else {
                        $xfer += $input->skip($ftype);
                    }
                    break;
                case 2:
                    if ($ftype == TType::STRING) {
                        $xfer += $input->readString($this->serializationLib);
                    } else {
                        $xfer += $input->skip($ftype);
                    }
                    break;
                case 3:
                    if ($ftype == TType::MAP) {
                        $this->parameters = array();
                        $_size157 = 0;
                        $_ktype158 = 0;
                        $_vtype159 = 0;
                        $xfer += $input->readMapBegin($_ktype158, $_vtype159, $_size157);
                        for ($_i161 = 0; $_i161 < $_size157; ++$_i161) {
                            $key162 = '';
                            $val163 = '';
                            $xfer += $input->readString($key162);
                            $xfer += $input->readString($val163);
                            $this->parameters[$key162] = $val163;
                        }
                        $xfer += $input->readMapEnd();
                    } else {
                        $xfer += $input->skip($ftype);
                    }
                    break;
                case 4:
                    if ($ftype == TType::STRING) {
                        $xfer += $input->readString($this->description);
                    } else {
                        $xfer += $input->skip($ftype);
                    }
                    break;
                case 5:
                    if ($ftype == TType::STRING) {
                        $xfer += $input->readString($this->serializerClass);
                    } else {
                        $xfer += $input->skip($ftype);
                    }
                    break;
                case 6:
                    if ($ftype == TType::STRING) {
                        $xfer += $input->readString($this->deserializerClass);
                    } else {
                        $xfer += $input->skip($ftype);
                    }
                    break;
                case 7:
                    if ($ftype == TType::I32) {
                        $xfer += $input->readI32($this->serdeType);
                    } else {
                        $xfer += $input->skip($ftype);
                    }
                    break;
                default:
                    $xfer += $input->skip($ftype);
                    break;
            }
            $xfer += $input->readFieldEnd();
        }
        $xfer += $input->readStructEnd();
        return $xfer;
    }

    public function write($output)
    {
        $xfer = 0;
        $xfer += $output->writeStructBegin('SerDeInfo');
        if ($this->name !== null) {
            $xfer += $output->writeFieldBegin('name', TType::STRING, 1);
            $xfer += $output->writeString($this->name);
            $xfer += $output->writeFieldEnd();
        }
        if ($this->serializationLib !== null) {
            $xfer += $output->writeFieldBegin('serializationLib', TType::STRING, 2);
            $xfer += $output->writeString($this->serializationLib);
            $xfer += $output->writeFieldEnd();
        }
        if ($this->parameters !== null) {
            if (!is_array($this->parameters)) {
                throw new TProtocolException('Bad type in structure.', TProtocolException::INVALID_DATA);
            }
            $xfer += $output->writeFieldBegin('parameters', TType::MAP, 3);
            $output->writeMapBegin(TType::STRING, TType::STRING, count($this->parameters));
            foreach ($this->parameters as $kiter164 => $viter165) {
                $xfer += $output->writeString($kiter164);
                $xfer += $output->writeString($viter165);
            }
            $output->writeMapEnd();
            $xfer += $output->writeFieldEnd();
        }
        if ($this->description !== null) {
            $xfer += $output->writeFieldBegin('description', TType::STRING, 4);
            $xfer += $output->writeString($this->description);
            $xfer += $output->writeFieldEnd();
        }
        if ($this->serializerClass !== null) {
            $xfer += $output->writeFieldBegin('serializerClass', TType::STRING, 5);
            $xfer += $output->writeString($this->serializerClass);
            $xfer += $output->writeFieldEnd();
        }
        if ($this->deserializerClass !== null) {
            $xfer += $output->writeFieldBegin('deserializerClass', TType::STRING, 6);
            $xfer += $output->writeString($this->deserializerClass);
            $xfer += $output->writeFieldEnd();
        }
        if ($this->serdeType !== null) {
            $xfer += $output->writeFieldBegin('serdeType', TType::I32, 7);
            $xfer += $output->writeI32($this->serdeType);
            $xfer += $output->writeFieldEnd();
        }
        $xfer += $output->writeFieldStop();
        $xfer += $output->writeStructEnd();
        return $xfer;
    }
}
