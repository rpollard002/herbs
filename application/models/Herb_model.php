<?php
/**
 * Created by PhpStorm.
 * User: rpollard
 * Date: 6/16/15
 * Time: 1:31 PM
 */

class Herb_model extends CI_Model{

    function __construct()
    {
        parent::__construct();

    }

    function getHerbData($herb_id)
    {
        if($herb_id)
        {

        $sql_query = "  select
                            id
                            , description
                            , benefits
                            , herb_picture
                            from herb
                            where id = " . $herb_id;

        $query = $this->db->query($sql_query);
        $row = $query->row();
        $herb_data = array("id" => $row->id
                          ,"description" => $row->description
                          ,"benefits" => $row->benefits);
        return $herb_data;

        }
    }

    function getHerbList()
    {
        $data = array();
        $curr_row = 0;
        $sql_query = "  select
                        id
                        , description
                        , benefits
                        from herb
                     ";
        $query = $this->db->query($sql_query);
        $num_columns = $query->num_fields();
        $num_rows = $query->num_rows();
        foreach ($query->result() as $row)
        {
            array_push($data, array($row->id, $row->description, $row->benefits));
        }
        return $data;
    }

    function saveHerb()
    {
        // Check to see if formula data exists...
        $herb_id = $this->input->post('id');
        $herb_description = $this->input->post('description');
        $herb_benefits = $this->db->escape_str($this->input->post('benefits'));

        if($herb_id == "")
        {
            $herb_id = "NULL";
            $herb_sql_statement = "INSERT INTO herb_management.herb (id, description, benefits) values(" . $herb_id . ", '" . $herb_description . "', '" . $herb_benefits . "')";
        } else {
            $herb_sql_statement = "UPDATE herb_management.herb  SET description = '" . $herb_description . "', benefits = '" . $herb_benefits . "' WHERE id = " . $herb_id;
        }
        $this->db->query($herb_sql_statement);

        $sql_values = "";
        $values = "";

    }
} 