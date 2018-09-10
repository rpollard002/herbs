<?php
/**
 * Created by PhpStorm.
 * User: rpollard
 * Date: 11/8/15
 * Time: 9:28 PM
 */

class Herb_inventory_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();

    }
    function loadHerb($p_herb_id)
    {
        $data = array();
        $sql_query = "  select description
                               , qty
                               from herb
                        where id = " . $p_herb_id['id'];
        $query = $this->db->query($sql_query);
        $row = $query->row();
        array_push($data, array('id' => $p_herb_id['id'], 'description' => $row->description, 'qty' => $row->qty));
        return $data;

    }
    function loadHerbInventoryHistory($p_herb_id)
    {
        $data = array();
        $curr_row = 0;
        $sql_query = "  select date_format(ia.date_adjusted, '%m/%d/%Y') as date_adjusted
                               , ia.qty as qty
                               , ias.description as source
                               from inventory_adjustments as ia
                        join  inventory_adjustment_source as ias on ias.id = ia.inventory_adjustment_source_id
                        where ia.herb_id = " . $p_herb_id['id'] . " order by date_adjusted";
        $query = $this->db->query($sql_query);
        foreach ($query->result() as $row)
        {
            array_push($data, array($row->date_adjusted, $row->qty, $row->source));
        }

        return $data;

    }

}