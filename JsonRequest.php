<?php

/**
 * JSONREQUEST
 * -----------
 * Description: Query a simple standard JSON file (from One table MySQL export)
 * Version: 1.0
 * Author: Frédéric Leclercq
 */


class JsonRequest
{

    protected $file = null;
    protected $selection = null;
    protected $currentfile = null;

    public function __construct(Mixed $file, Bool $isfile = true)
    {
        if ($isfile && file_exists($file)) {
            $this->currentfile = $file;
            $this->file = json_decode(file_get_contents($file));
        } elseif(!$isfile){
            $this->file = $file;
        }
        else throw new Exception('File not found : ' . $file . ' or invalid ressource');

        
    }

    public function filter(String $field, Mixed $value, String $comparator = '==', Bool $case_sensitive = false): object
    {
        if (is_null($this->file)) throw new Error('Unknown source');
        if (!is_null($this->selection))  $source = $this->selection;
        if (empty($source)) $source = $this->file;

        $source_columns =  array_column($source, $field);


        switch ($comparator) {
            case '==':
                if (!$case_sensitive) {
                    $value = strtolower($value);
                    $filtered_datas =  array_keys(array_map('strtolower', $source_columns), $value);
                } else {
                    $filtered_datas =  array_keys($source_columns, $value);
                }

                break;

            case 'LIKE':
                if (!$case_sensitive) {
                    $value = strtolower($value);
                    $filtered_datas = array_keys(array_filter(
                        $source,
                        function ($ligne) use ($field, $value) {;
                            return (strpos(strtolower($ligne->{$field}), $value) !== false);
                        }
                    ));
                } else {
                    $filtered_datas = array_keys(array_filter(
                        $source,
                        function ($ligne) use ($field, $value) {;
                            return (strpos($ligne->{$field}, $value) !== false);
                        }
                    ));
                }

                break;
            case 'BETWEEN':
                $min = $value[0];
                $max = $value[1];
                $filtered_datas = array_keys(array_filter(
                    $source,
                    function ($ligne) use ($field, $min, $max) {;
                        return ($ligne->{$field} >= $min &&  $ligne->{$field} <= $max);
                    }
                ));
                break;

            case '>':
                $filtered_datas = array_keys(array_filter(
                    $source,
                    function ($ligne) use ($field, $value) {;
                        return ($ligne->{$field} > $value);
                    }
                ));
                break;
            case '<':
                $filtered_datas = array_keys(array_filter(
                    $source,
                    function ($ligne) use ($field, $value) {;
                        return ($ligne->{$field} < $value);
                    }
                ));
                break;
            case '>=':
                $filtered_datas = array_keys(array_filter(
                    $source,
                    function ($ligne) use ($field, $value) {;
                        return ($ligne->{$field} >= $value);
                    }
                ));
                break;
            case '<=':
                $filtered_datas = array_keys(array_filter(
                    $source,
                    function ($ligne) use ($field, $value) {;
                        return ($ligne->{$field} <= $value);
                    }
                ));
                break;
        }

        $results = [];
        foreach ($filtered_datas as $id) {
            $results[] =  $source[$id];
        }
        $this->selection = $results;
        return $this;
    }

    public function getColumns(): array
    {
        if (!empty($this->file)) {
            $first = $this->file[0];
            return array_keys((array)$first);
        } else {
            return [];
        }
    }

    public function getDatas() : array
    {
        if (is_null($this->file)) throw new Exception('Unknown source');
        $tab = null;
        if (!is_null($this->selection)) $tab = $this->selection;
        if (is_null($tab)) $tab = $this->file;
        return $tab;
    }

    public function showDatas(array $onlycolumns = array(), Bool $reset = true): String
    {

        if (is_null($this->file)) throw new Exception('Unknown source');

        $tab = null;
        if (!is_null($this->selection)) $tab = $this->selection;
        if (is_null($tab)) $tab = $this->file;

        if (empty($onlycolumns)) $columns = $this->getColumns();
        else $columns = $onlycolumns;

        $html = '<table class="jsonrequest"><tr>';
        foreach ($columns as $column) {

            $html .= '<th>' . $column . '</th>';
        }
        $html .= '</tr>';

        foreach ($tab as $ligne) {
            $html .= '<tr>';
            foreach ($columns as $column) {

                $html .= '<td>' . $ligne->{$column} . '</td>';
            }
            $html .= '</tr>';
        }
        $html .= '</table>';

        // reset selection after display
        if ($reset) $this->reset();

        return $html;
    }

    public function sort(String $field, String $direction = 'ASC'): object
    {

        if (is_null($this->file)) throw new Exception('Unknown source');

        if (!is_null($this->selection)) $source = &$this->selection;
        if (empty($source))  $source = &$this->file;

        if ($direction == 'ASC')
            usort($source,  function ($a, $b) use ($field) {
                return strcmp($a->{$field}, $b->{$field});
            });
        if ($direction == 'DESC')
            usort($source,  function ($a, $b) use ($field) {
                return strcmp($b->{$field}, $a->{$field});
            });

        return $this;
    }

    public function reset(): object
    {
        $this->selection = null;
        return $this;
    }

    public static function catchError($error)
    {
        echo "<p>" . $error->getMessage() . "</p>";
    }

    public function __toString()
    {
        return  '<p>Current file: ' . $this->currentfile . '</p>';
    }
}

set_exception_handler(array('JsonRequest', 'catchError'));
