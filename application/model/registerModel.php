<?php

class registerModel extends basisModel {

//columnsName in MySQL : id_temetable,id_group,id_student,attendance,assesment,homework,remarks.
    protected $idTemetable;
    protected $lesson;
    protected $idGroup;
    protected $group;
    protected $arrRegisterLine;
    protected $arrStudents;
    protected $speaker;

    public function __construct($arrParameter) {
        if (!empty($arrParameter) && (is_array($arrParameter))) {
            foreach ($arrParameter as $key => $value) {
                if (in_array($key, array('idTemetable', 'lesson', 'idGroup', 'group', 'arrRegisterLine', 'arrStudents', 'speaker'))) {
                    $this->$key = $value;
                }
            }
        }
    }

    public static function fromState($state) {
        return new self($state);
    }

}
