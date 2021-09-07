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

class ObjectDictionary
{
    static public $isValidate = false;

    static public $_TSPEC = array(
        1 => array(
            'var' => 'values',
            'isRequired' => true,
            'type' => TType::MAP,
            'ktype' => TType::STRING,
            'vtype' => TType::LST,
            'key' => array(
                'type' => TType::STRING,
            ),
            'val' => array(
                'type' => TType::LST,
                'etype' => TType::STRING,
                'elem' => array(
                    'type' => TType::STRING,
                    ),
                ),
        ),
    );

    /**
     * @var array
     */
    public $values = null;

    public function __construct($vals = null)
    {
        if (is_array($vals)) {
            if (isset($vals['values'])) {
                $this->values = $vals['values'];
            }
        }
    }

    public function getName()
    {
        return 'ObjectDictionary';
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
                    if ($ftype == TType::MAP) {
                        $this->values = array();
                        $_size255 = 0;
                        $_ktype256 = 0;
                        $_vtype257 = 0;
                        $xfer += $input->readMapBegin($_ktype256, $_vtype257, $_size255);
                        for ($_i259 = 0; $_i259 < $_size255; ++$_i259) {
                            $key260 = '';
                            $val261 = array();
                            $xfer += $input->readString($key260);
                            $val261 = array();
                            $_size262 = 0;
                            $_etype265 = 0;
                            $xfer += $input->readListBegin($_etype265, $_size262);
                            for ($_i266 = 0; $_i266 < $_size262; ++$_i266) {
                                $elem267 = null;
                                $xfer += $input->readString($elem267);
                                $val261 []= $elem267;
                            }
                            $xfer += $input->readListEnd();
                            $this->values[$key260] = $val261;
                        }
                        $xfer += $input->readMapEnd();
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
        $xfer += $output->writeStructBegin('ObjectDictionary');
        if ($this->values !== null) {
            if (!is_array($this->values)) {
                throw new TProtocolException('Bad type in structure.', TProtocolException::INVALID_DATA);
            }
            $xfer += $output->writeFieldBegin('values', TType::MAP, 1);
            $output->writeMapBegin(TType::STRING, TType::LST, count($this->values));
            foreach ($this->values as $kiter268 => $viter269) {
                $xfer += $output->writeString($kiter268);
                $output->writeListBegin(TType::STRING, count($viter269));
                foreach ($viter269 as $iter270) {
                    $xfer += $output->writeString($iter270);
                }
                $output->writeListEnd();
            }
            $output->writeMapEnd();
            $xfer += $output->writeFieldEnd();
        }
        $xfer += $output->writeFieldStop();
        $xfer += $output->writeStructEnd();
        return $xfer;
    }
}
