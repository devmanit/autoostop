<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * CakePHP PropertiesComponent
 * @author Ayoub
 */
class PropertiesComponent extends Component {

    public $controller = false;
    public $components=array('RequestHandler');
    public function __construct(ComponentCollection $collection, $setting)
    {
        $this->controller = $collection->getController();
    }
    
    /*
     * This function is used in admin
     * It paginate properties with some conditions
     */
    public function paginateAdminProperties($properties_data)
    {
        $criteria = array(
            'OR' => array(
                'Property.pricedt LIKE' => '%'.$properties_data['Property']['filter'].'%',
                'PropertyAddress.country LIKE' => '%'.$properties_data['Property']['filter'].'%',
                'PropertyAddress.province LIKE' => '%'.$properties_data['Property']['filter'].'%',
                'PropertyAddress.city LIKE' => '%'.$properties_data['Property']['filter'].'%',
                'PropertyAddress.line_address LIKE' => '%'.$properties_data['Property']['filter'].'%',
                'PropertyAddress.country_des LIKE' => '%'.$properties_data['Property']['filter'].'%',
                'PropertyAddress.province_des LIKE' => '%'.$properties_data['Property']['filter'].'%',
                'PropertyAddress.city_des LIKE' => '%'.$properties_data['Property']['filter'].'%',
                'PropertyAddress.line_address_des LIKE' => '%'.$properties_data['Property']['filter'].'%',
             ),
            );
       return $criteria;
    }
    
    /*
     * Create some specific attributes before saving data to database
     * admin_add()
     * admin_edit()
     */
    public function specificAddEditData($properties_data)
    {
        //table containing specific attributes values
       // Return this table to admin_add or admin_edit to explore values.
        $array_specific_attributes = null;
       
        //create specifications data
        if(isset($properties_data['Specification']))
        {
            $spec = '';
             foreach ($properties_data['Specification'] as $id_spec => $array_spec) {

                 $spec .= $array_spec['specName'].',';
             } 
             $spec = substr($spec, 0, strlen($spec)-1);
             $array_specific_attributes ['specification'] = $spec;
        }
        else
        {
             $array_specific_attributes ['specification'] = '';
        }
         //create specifications data 
        
        return $array_specific_attributes;
    }
    public function searchKeyWords($filter)
    {
        $key_words = explode(' ',$filter) ;
        foreach ($key_words as $word) {
          $criteria[] = array(
            'OR' => array(
                'Property.name LIKE' => '%'.$word.'%',
                'Property.pcategory LIKE' => '%'.$word.'%'
                  ),
            );  
        }
        $criteria['Property.status'] = 1; 
        
        return $criteria;
    }
    
    public function advancedSearch($propadvanced)
    {
        
        
       if($propadvanced['departure_country'] != '')
       {
           $criteria[] = array(
                'OR' => array(
                    'PropertyAddress.country LIKE' => '%'.$propadvanced['departure_country'].'%',
                 ),
                 'AND' => array(
                    'PropertyAddress.country_des LIKE' => '%'.$propadvanced['destination_country'].'%',
                 ),
            ); 
       }
       //province
       if(isset($propadvanced['departure_province'])&&isset($propadvanced['destination_province']))
       {
           $criteria[] = array(
                'OR' => array(
                    'PropertyAddress.province' => $propadvanced['departure_province'],
                 ),
                 'AND' => array(
                    'PropertyAddress.province_des' => $propadvanced['destination_province'],
                 ),
            ); 
       }
       else
           if(isset($propadvanced['departure_province'])&&!isset($propadvanced['destination_province']))
           {
             $criteria[] = array(
                'OR' => array(
                    'PropertyAddress.province' => $propadvanced['departure_province'],
                 ),
            );   
           }
           else
           if(!isset($propadvanced['departure_province'])&&isset($propadvanced['destination_province']))
           {
             $criteria[] = array(
                'OR' => array(
                    'PropertyAddress.province_des' => $propadvanced['destination_province'],
                 ),
             );   
           }
       //province
           
      //city
       if($propadvanced['departure_city'] !='' && $propadvanced['destination_city'] !='')
       {
           $criteria[] = array(
                'OR' => array(
                    'PropertyAddress.city LIKE' => '%'.$propadvanced['departure_city'].'%',
                 ),
                 'AND' => array(
                    'PropertyAddress.city_des LIKE' => '%'.$propadvanced['destination_city'].'%',
                 ),
            ); 
       }
       else
           if($propadvanced['departure_city'] !='' && $propadvanced['destination_city'] =='' )
           {
             $criteria[] = array(
                'OR' => array(
                    'PropertyAddress.city LIKE' => '%'.$propadvanced['departure_city'].'%',
                 ),
            );   
           }
           else
           if($propadvanced['departure_city'] =='' && $propadvanced['destination_city'] !='' )
           {
             $criteria[] = array(
                'OR' => array(
                    'PropertyAddress.city_des LIKE' => '%'.$propadvanced['destination_city'].'%',
                 ),
             );   
           }
       //city
      if($propadvanced['departure_offres'] != '')
       {
          //date controle
          $today = date('Y-m-d', strtotime(date('Y-m-d'). ' + 2 days'));
           if($propadvanced['departure_offres'] == 'available')
           {
            $criteria[] = array(
                 'OR' => array(
                     'Property.reserved < Property.rooms',
                  ),
                'OR' => array(
                     'Property.datedepart >=' => $today
                  ),
             ); 
           }
       }
       //Use range date
        if($propadvanced['date_depart_from'] != '' || $propadvanced['date_depart_end'] != '')
        {
            //Range between two dates
            if($propadvanced['date_depart_from'] != '' && $propadvanced['date_depart_end'] != '')
            {
                $criteria[] = array(
                     'OR' => array(
                         'Property.datedepart BETWEEN ? AND ?' => array($propadvanced['date_depart_from'],$propadvanced['date_depart_end'])
                      ),
                 );
            }
            else if($propadvanced['date_depart_from'] != '' && $propadvanced['date_depart_end'] == '')
            {
                //Range > date depart from
                $criteria[] = array(
                    'OR' => array(
                        'Property.datedepart >=' => $propadvanced['date_depart_from'],
                     ),
                ); 
            }
            else if($propadvanced['date_depart_from'] == '' || $propadvanced['date_depart_end'] != '')
            {
                //Range < date depart end
                $criteria[] = array(
                    'OR' => array(
                        'Property.datedepart <=' => $propadvanced['date_depart_end'],
                     ),
                );
            }
        }
        else
            if($propadvanced['date_depart_fixed'] != '')
            {
                //use fixed date
                $criteria[] = array(
                    'OR' => array(
                        'Property.datedepart ' => $propadvanced['date_depart_fixed'],
                     ),
                );
            }
       return $criteria;
    }

}
