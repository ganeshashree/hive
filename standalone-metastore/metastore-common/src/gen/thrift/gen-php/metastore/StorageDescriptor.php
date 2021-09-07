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

class StorageDescriptor
{
    static public $isValidate = false;

    static public $_TSPEC = array(
        1 => array(
            'var' => 'cols',
            'isRequired' => false,
            'type' => TType::LST,
            'etype' => TType::STRUCT,
            'elem' => array(
                'type' => TType::STRUCT,
                'class' => '\metastore\FieldSchema',
                ),
        ),
        2 => array(
            'var' => 'location',
            'isRequired' => false,
            'type' => TType::STRING,
        ),
        3 => array(
            'var' => 'inputFormat',
            'isRequired' => false,
            'type' => TType::STRING,
        ),
        4 => array(
            'var' => 'outputFormat',
            'isRequired' => false,
            'type' => TType::STRING,
        ),
        5 => array(
            'var' => 'compressed',
            'isRequired' => false,
            'type' => TType::BOOL,
        ),
        6 => array(
            'var' => 'numBuckets',
            'isRequired' => false,
            'type' => TType::I32,
        ),
        7 => array(
            'var' => 'serdeInfo',
            'isRequired' => false,
            'type' => TType::STRUCT,
            'class' => '\metastore\SerDeInfo',
        ),
        8 => array(
            'var' => 'bucketCols',
            'isRequired' => false,
            'type' => TType::LST,
            'etype' => TType::STRING,
            'elem' => array(
                'type' => TType::STRING,
                ),
        ),
        9 => array(
            'var' => 'sortCols',
            'isRequired' => false,
            'type' => TType::LST,
            'etype' => TType::STRUCT,
            'elem' => array(
                'type' => TType::STRUCT,
                'class' => '\metastore\Order',
                ),
        ),
        10 => array(
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
        11 => array(
            'var' => 'skewedInfo',
            'isRequired' => false,
            'type' => TType::STRUCT,
            'class' => '\metastore\SkewedInfo',
        ),
        12 => array(
            'var' => 'storedAsSubDirectories',
            'isRequired' => false,
            'type' => TType::BOOL,
        ),
    );

    /**
     * @var \metastore\FieldSchema[]
     */
    public $cols = null;
    /**
     * @var string
     */
    public $location = null;
    /**
     * @var string
     */
    public $inputFormat = null;
    /**
     * @var string
     */
    public $outputFormat = null;
    /**
     * @var bool
     */
    public $compressed = null;
    /**
     * @var int
     */
    public $numBuckets = null;
    /**
     * @var \metastore\SerDeInfo
     */
    public $serdeInfo = null;
    /**
     * @var string[]
     */
    public $bucketCols = null;
    /**
     * @var \metastore\Order[]
     */
    public $sortCols = null;
    /**
     * @var array
     */
    public $parameters = null;
    /**
     * @var \metastore\SkewedInfo
     */
    public $skewedInfo = null;
    /**
     * @var bool
     */
    public $storedAsSubDirectories = null;

    public function __construct($vals = null)
    {
        if (is_array($vals)) {
            if (isset($vals['cols'])) {
                $this->cols = $vals['cols'];
            }
            if (isset($vals['location'])) {
                $this->location = $vals['location'];
            }
            if (isset($vals['inputFormat'])) {
                $this->inputFormat = $vals['inputFormat'];
            }
            if (isset($vals['outputFormat'])) {
                $this->outputFormat = $vals['outputFormat'];
            }
            if (isset($vals['compressed'])) {
                $this->compressed = $vals['compressed'];
            }
            if (isset($vals['numBuckets'])) {
                $this->numBuckets = $vals['numBuckets'];
            }
            if (isset($vals['serdeInfo'])) {
                $this->serdeInfo = $vals['serdeInfo'];
            }
            if (isset($vals['bucketCols'])) {
                $this->bucketCols = $vals['bucketCols'];
            }
            if (isset($vals['sortCols'])) {
                $this->sortCols = $vals['sortCols'];
            }
            if (isset($vals['parameters'])) {
                $this->parameters = $vals['parameters'];
            }
            if (isset($vals['skewedInfo'])) {
                $this->skewedInfo = $vals['skewedInfo'];
            }
            if (isset($vals['storedAsSubDirectories'])) {
                $this->storedAsSubDirectories = $vals['storedAsSubDirectories'];
            }
        }
    }

    public function getName()
    {
        return 'StorageDescriptor';
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
                    if ($ftype == TType::LST) {
                        $this->cols = array();
                        $_size203 = 0;
                        $_etype206 = 0;
                        $xfer += $input->readListBegin($_etype206, $_size203);
                        for ($_i207 = 0; $_i207 < $_size203; ++$_i207) {
                            $elem208 = null;
                            $elem208 = new \metastore\FieldSchema();
                            $xfer += $elem208->read($input);
                            $this->cols []= $elem208;
                        }
                        $xfer += $input->readListEnd();
                    } else {
                        $xfer += $input->skip($ftype);
                    }
                    break;
                case 2:
                    if ($ftype == TType::STRING) {
                        $xfer += $input->readString($this->location);
                    } else {
                        $xfer += $input->skip($ftype);
                    }
                    break;
                case 3:
                    if ($ftype == TType::STRING) {
                        $xfer += $input->readString($this->inputFormat);
                    } else {
                        $xfer += $input->skip($ftype);
                    }
                    break;
                case 4:
                    if ($ftype == TType::STRING) {
                        $xfer += $input->readString($this->outputFormat);
                    } else {
                        $xfer += $input->skip($ftype);
                    }
                    break;
                case 5:
                    if ($ftype == TType::BOOL) {
                        $xfer += $input->readBool($this->compressed);
                    } else {
                        $xfer += $input->skip($ftype);
                    }
                    break;
                case 6:
                    if ($ftype == TType::I32) {
                        $xfer += $input->readI32($this->numBuckets);
                    } else {
                        $xfer += $input->skip($ftype);
                    }
                    break;
                case 7:
                    if ($ftype == TType::STRUCT) {
                        $this->serdeInfo = new \metastore\SerDeInfo();
                        $xfer += $this->serdeInfo->read($input);
                    } else {
                        $xfer += $input->skip($ftype);
                    }
                    break;
                case 8:
                    if ($ftype == TType::LST) {
                        $this->bucketCols = array();
                        $_size209 = 0;
                        $_etype212 = 0;
                        $xfer += $input->readListBegin($_etype212, $_size209);
                        for ($_i213 = 0; $_i213 < $_size209; ++$_i213) {
                            $elem214 = null;
                            $xfer += $input->readString($elem214);
                            $this->bucketCols []= $elem214;
                        }
                        $xfer += $input->readListEnd();
                    } else {
                        $xfer += $input->skip($ftype);
                    }
                    break;
                case 9:
                    if ($ftype == TType::LST) {
                        $this->sortCols = array();
                        $_size215 = 0;
                        $_etype218 = 0;
                        $xfer += $input->readListBegin($_etype218, $_size215);
                        for ($_i219 = 0; $_i219 < $_size215; ++$_i219) {
                            $elem220 = null;
                            $elem220 = new \metastore\Order();
                            $xfer += $elem220->read($input);
                            $this->sortCols []= $elem220;
                        }
                        $xfer += $input->readListEnd();
                    } else {
                        $xfer += $input->skip($ftype);
                    }
                    break;
                case 10:
                    if ($ftype == TType::MAP) {
                        $this->parameters = array();
                        $_size221 = 0;
                        $_ktype222 = 0;
                        $_vtype223 = 0;
                        $xfer += $input->readMapBegin($_ktype222, $_vtype223, $_size221);
                        for ($_i225 = 0; $_i225 < $_size221; ++$_i225) {
                            $key226 = '';
                            $val227 = '';
                            $xfer += $input->readString($key226);
                            $xfer += $input->readString($val227);
                            $this->parameters[$key226] = $val227;
                        }
                        $xfer += $input->readMapEnd();
                    } else {
                        $xfer += $input->skip($ftype);
                    }
                    break;
                case 11:
                    if ($ftype == TType::STRUCT) {
                        $this->skewedInfo = new \metastore\SkewedInfo();
                        $xfer += $this->skewedInfo->read($input);
                    } else {
                        $xfer += $input->skip($ftype);
                    }
                    break;
                case 12:
                    if ($ftype == TType::BOOL) {
                        $xfer += $input->readBool($this->storedAsSubDirectories);
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
        $xfer += $output->writeStructBegin('StorageDescriptor');
        if ($this->cols !== null) {
            if (!is_array($this->cols)) {
                throw new TProtocolException('Bad type in structure.', TProtocolException::INVALID_DATA);
            }
            $xfer += $output->writeFieldBegin('cols', TType::LST, 1);
            $output->writeListBegin(TType::STRUCT, count($this->cols));
            foreach ($this->cols as $iter228) {
                $xfer += $iter228->write($output);
            }
            $output->writeListEnd();
            $xfer += $output->writeFieldEnd();
        }
        if ($this->location !== null) {
            $xfer += $output->writeFieldBegin('location', TType::STRING, 2);
            $xfer += $output->writeString($this->location);
            $xfer += $output->writeFieldEnd();
        }
        if ($this->inputFormat !== null) {
            $xfer += $output->writeFieldBegin('inputFormat', TType::STRING, 3);
            $xfer += $output->writeString($this->inputFormat);
            $xfer += $output->writeFieldEnd();
        }
        if ($this->outputFormat !== null) {
            $xfer += $output->writeFieldBegin('outputFormat', TType::STRING, 4);
            $xfer += $output->writeString($this->outputFormat);
            $xfer += $output->writeFieldEnd();
        }
        if ($this->compressed !== null) {
            $xfer += $output->writeFieldBegin('compressed', TType::BOOL, 5);
            $xfer += $output->writeBool($this->compressed);
            $xfer += $output->writeFieldEnd();
        }
        if ($this->numBuckets !== null) {
            $xfer += $output->writeFieldBegin('numBuckets', TType::I32, 6);
            $xfer += $output->writeI32($this->numBuckets);
            $xfer += $output->writeFieldEnd();
        }
        if ($this->serdeInfo !== null) {
            if (!is_object($this->serdeInfo)) {
                throw new TProtocolException('Bad type in structure.', TProtocolException::INVALID_DATA);
            }
            $xfer += $output->writeFieldBegin('serdeInfo', TType::STRUCT, 7);
            $xfer += $this->serdeInfo->write($output);
            $xfer += $output->writeFieldEnd();
        }
        if ($this->bucketCols !== null) {
            if (!is_array($this->bucketCols)) {
                throw new TProtocolException('Bad type in structure.', TProtocolException::INVALID_DATA);
            }
            $xfer += $output->writeFieldBegin('bucketCols', TType::LST, 8);
            $output->writeListBegin(TType::STRING, count($this->bucketCols));
            foreach ($this->bucketCols as $iter229) {
                $xfer += $output->writeString($iter229);
            }
            $output->writeListEnd();
            $xfer += $output->writeFieldEnd();
        }
        if ($this->sortCols !== null) {
            if (!is_array($this->sortCols)) {
                throw new TProtocolException('Bad type in structure.', TProtocolException::INVALID_DATA);
            }
            $xfer += $output->writeFieldBegin('sortCols', TType::LST, 9);
            $output->writeListBegin(TType::STRUCT, count($this->sortCols));
            foreach ($this->sortCols as $iter230) {
                $xfer += $iter230->write($output);
            }
            $output->writeListEnd();
            $xfer += $output->writeFieldEnd();
        }
        if ($this->parameters !== null) {
            if (!is_array($this->parameters)) {
                throw new TProtocolException('Bad type in structure.', TProtocolException::INVALID_DATA);
            }
            $xfer += $output->writeFieldBegin('parameters', TType::MAP, 10);
            $output->writeMapBegin(TType::STRING, TType::STRING, count($this->parameters));
            foreach ($this->parameters as $kiter231 => $viter232) {
                $xfer += $output->writeString($kiter231);
                $xfer += $output->writeString($viter232);
            }
            $output->writeMapEnd();
            $xfer += $output->writeFieldEnd();
        }
        if ($this->skewedInfo !== null) {
            if (!is_object($this->skewedInfo)) {
                throw new TProtocolException('Bad type in structure.', TProtocolException::INVALID_DATA);
            }
            $xfer += $output->writeFieldBegin('skewedInfo', TType::STRUCT, 11);
            $xfer += $this->skewedInfo->write($output);
            $xfer += $output->writeFieldEnd();
        }
        if ($this->storedAsSubDirectories !== null) {
            $xfer += $output->writeFieldBegin('storedAsSubDirectories', TType::BOOL, 12);
            $xfer += $output->writeBool($this->storedAsSubDirectories);
            $xfer += $output->writeFieldEnd();
        }
        $xfer += $output->writeFieldStop();
        $xfer += $output->writeStructEnd();
        return $xfer;
    }
}
