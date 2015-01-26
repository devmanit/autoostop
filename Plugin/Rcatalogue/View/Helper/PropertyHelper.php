<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * CakePHP PropertyHelper
 * @author Ayoub
 */
class PropertyHelper extends AppHelper {

    public $helpers = array('Html', 'Form');

     
     
    public function renderLastProperties($properties = null) {
        
         $output = '';
         $euro_setting = Configure::read('price.euro');
        
         if($properties == null)
        {
           //error , maybe database connection or something else 
        }
        else
        {
            foreach ($properties as $index => $proparray) {
                
                $output .= '
                <div class="scroll-item">
                    <div class="post-thumbnail">';
                
                $output.= $this->Html->image('/croogo/img/layout/icone-date-red.jpg', array('url' => array(
                                                                                        'plugin' => 'rcatalogue',
                                                                                        'controller' => 'properties',
                                                                                        'action' => 'propertydetails',
                                                                                        $proparray['Property']['id']
                                                                                    ))).'</div>';
                $output.= '<span class="year_depart">'.strftime("%Y",strtotime($proparray['Property']['datedepart'])).' '.strftime("%b",strtotime($proparray['Property']['datedepart'])).'</span>';
                $output.= '<span class="month_depart">'.$this->Html->Link(strftime("%d",strtotime($proparray['Property']['datedepart'])),array(
                                                                                        'plugin' => 'rcatalogue',
                                                                                        'controller' => 'properties',
                                                                                        'action' => 'propertydetails',
                                                                                        $proparray['Property']['id']
                                                                                    )).'</span>';
                $output.= '<span class="day_depart">'.  strftime("%a",strtotime($proparray['Property']['datedepart'])).'</span>';
                //***** verify if the price is null 
                   $price = '';
                   if($proparray['Property']['pricedt']!=null)
                   { 
                      $price .= $proparray['Property']['pricedt'].'$';
                   }
                //***** verify if the price is null
                   
                //calculating evaluation
                if($proparray['User']['Userinfo'][0]['countponc'] == 0 ||
                   $proparray['User']['Userinfo'][0]['countpol'] == 0 ||
                    $proparray['User']['Userinfo'][0]['countsec'] == 0)
                {
                  $evaluation = 0;  
                }
                else
                {
                $evaluation = ($proparray['User']['Userinfo'][0]['noteponc']/$proparray['User']['Userinfo'][0]['countponc']+
                              $proparray['User']['Userinfo'][0]['notepol']/$proparray['User']['Userinfo'][0]['countpol']+ 
                              $proparray['User']['Userinfo'][0]['notesec']/$proparray['User']['Userinfo'][0]['countsec'])/3;
                $evaluation = $evaluation * 100;
                }
                
                $output.='<p class="price_depart">'.
                               $price.'<span class="stars-small"><span style="width:'.$evaluation.'%"></span></span> 
                            </p>';
                $output.='<p class="depart_country">'.$proparray['PropertyAddress'][0]['country'].'</p>';
                if(isset($proparray['PropertyAddress'][0]['province']) && $proparray['PropertyAddress'][0]['province'] != '')
                {$output.='<p class="depart_adr">'.$proparray['PropertyAddress'][0]['province'].', '.$proparray['PropertyAddress'][0]['city'].'</p>';}
                else
                {
                 $output.='<p class="depart_adr">'.$proparray['PropertyAddress'][0]['city'].'</p>';   
                }
                $output.='<p class="center_cla">&darr;</p>';
                $output.='<p class="depart_country">'.$proparray['PropertyAddress'][0]['country_des'].'</p>';
                if(isset($proparray['PropertyAddress'][0]['province_des']) && $proparray['PropertyAddress'][0]['province_des'] != '')
                {$output.='<p class="depart_adr">'.$proparray['PropertyAddress'][0]['province_des'].', '.$proparray['PropertyAddress'][0]['city_des'].'</p>';}
                else
                {
                 $output.='<p class="depart_adr">'.$proparray['PropertyAddress'][0]['city_des'].'</p>';   
                }
                
                $output.= '</div>';
            }
        }
       
        return $output;
    }
    public function renderAll($properties = null)
    {
        $output='';
        $euro_setting = Configure::read('price.euro');
        
        foreach ($properties as $index => $proparray) {
            $departdisabled = false;
            //Disable if date passed or complet
            if(new DateTime($proparray['Property']['datedepart'])<= new DateTime("now") ||
               ($proparray['Property']['reserved'] >= $proparray['Property']['rooms']))
            {
               $output .= '<tr class="odddisabled">';
               $departdisabled = true;
            }
            else
            {
                $output .= '<tr class="odd">';
            }
            //disable image if departdiabled
            $classdis = '';
            if($departdisabled == true)
            {
                $classdis = 'diabledimage';
            }
            $output .= '<td class="datetime">'.
                            $this->Html->image('/croogo/img/layout/blueArrow.png',array('class' => $classdis)).
                            '<br/>'.$proparray['Property']['datedepart'].'<br/>'.$proparray['Property']['heuredepart'].
                        '</td>';
            
            //disable link if departdiabled
            if($departdisabled == true)
            {
               $linkdepart = substr($proparray['PropertyAddress'][0]['city'],0, strpos($proparray['PropertyAddress'][0]['city'], ','));
               $linkarrive = substr($proparray['PropertyAddress'][0]['city_des'],0, strpos($proparray['PropertyAddress'][0]['city_des'], ','));
            }
            else {
               $linkdepart = $this->Html->Link(substr($proparray['PropertyAddress'][0]['city'],0, strpos($proparray['PropertyAddress'][0]['city'], ',')),'#modal',
                            array('onmouseover' => 'generateMap('.$proparray['PropertyAddress'][0]['latitude'].','.$proparray['PropertyAddress'][0]['longitude'].','.$proparray['PropertyAddress'][0]['zoom'].')'));
               $linkarrive = $this->Html->Link(substr($proparray['PropertyAddress'][0]['city_des'],0, strpos($proparray['PropertyAddress'][0]['city_des'], ',')),'#modal',
                            array('onmouseover' => 'generateMap('.$proparray['PropertyAddress'][0]['latitude_des'].','.$proparray['PropertyAddress'][0]['longitude_des'].','.$proparray['PropertyAddress'][0]['zoom_des'].')'));
            }
            
            $addept = $proparray['PropertyAddress'][0]['line_address'];
            $adarr = $proparray['PropertyAddress'][0]['line_address_des'];
            if(strlen($addept) > 30)
            {
                $addept = substr($addept,0,30);
                $addept .=' ...';
            }
            if(strlen($adarr) > 30)
            {
                $adarr = substr($adarr,0,30);
                $adarr .=' ...';
            }
            $output .= '<td class="datetime"><div class="city departure"><strong>'.
                            $proparray['PropertyAddress'][0]['province'].',</strong><span class="pickupDetails">'.
                            $linkdepart.',</span><span class="pickupDetails">'.$addept.'</span></div>'.
                        '</td>';
            $output .= '<td class="datetime"><div class="city destination"><strong>'.
                            $proparray['PropertyAddress'][0]['province_des'].',</strong><span class="pickupDetails">'.
                            $linkarrive.',</span><span class="pickupDetails">'.$adarr.'</span></div>'.
                        '</td>';
            $output .= '<td class="datetime">
                            <div class="itineraryPrice">
                            <p>'.
                                $proparray['Property']['pricedt'].'$<br>'.
                                $proparray['Property']['reserved'].'/'.$proparray['Property']['rooms'].
                            '</p>
                            </div>			
                        </td>';

            //view bagage icon
            $bagageimg ='<strong>'. $proparray['Car']['marque'].'</strong><br />';
            if($proparray['Property']['bagage'] == 'petit'){
                $bagageimg .= $this->Html->image('/croogo/img/layout/bagage-petit.png', array('style' => 'height:20px;'));
            }
            else if($proparray['Property']['bagage'] == 'moyen'){
                $bagageimg .= $this->Html->image('/croogo/img/layout/bagage-moyen.png', array('style' => 'height:20px;'));
            }
            else if($proparray['Property']['bagage'] == 'grand')
            {
                $bagageimg .= $this->Html->image('/croogo/img/layout/bagage-grand.png', array('style' => 'height:20px;'));
            }
            
            $output .= '<td class="datetime">
                            <div class="rideIcons '.$classdis.'">    
                            <p>'.
                                $bagageimg.
                            '</p>
                            </div>
                        </td>';
            
            //view conditions
            $array_condition = explode(',', $proparray['Property']['spec']);
            $output .= '<td class="datetime"><div class="rideIcons '.$classdis.'">    
                                <p>'
                                .$this->Html->image('/croogo/img/layout/espacefumeur-'.$array_condition[0].'.gif').
                                 $this->Html->image('/croogo/img/layout/airclimatise-'.$array_condition[1].'.gif').'<br/>'.
                                 $this->Html->image('/croogo/img/layout/supportvelo-'.$array_condition[2].'.gif').
                                 $this->Html->image('/croogo/img/layout/supportski-'.$array_condition[3].'.gif').'<br/>'.
                                 $this->Html->image('/croogo/img/layout/animaux-'.$array_condition[4].'.gif').
                                 $this->Html->image('/croogo/img/layout/numeroconducteur-'.$array_condition[5].'.gif').
                                '</p>
                            </div>
                        </td>';
            
            //calculating evaluation
                if($proparray['User']['Userinfo'][0]['countponc'] == 0 ||
                   $proparray['User']['Userinfo'][0]['countpol'] == 0 ||
                    $proparray['User']['Userinfo'][0]['countsec'] == 0)
                {
                  $evaluation = 0;  
                }
                else
                {
                $evaluation = ($proparray['User']['Userinfo'][0]['noteponc']/$proparray['User']['Userinfo'][0]['countponc']+
                              $proparray['User']['Userinfo'][0]['notepol']/$proparray['User']['Userinfo'][0]['countpol']+ 
                              $proparray['User']['Userinfo'][0]['notesec']/$proparray['User']['Userinfo'][0]['countsec'])/3;
                $evaluation = $evaluation * 100;
                }
            $output .= '<td class="datetime">
                            <span class="stars-small '.$classdis.'"><span style="width:'.$evaluation.'%"></span></span>
                        </td>';
            
            if($departdisabled == false)
            {
            $output .='<td>'.
                    $this->Html->image('/croogo/img/layout/details-annonce.png',
                                        array('url'=> array(
                                                'plugin' => 'rcatalogue',
                                                'controller' => 'properties',
                                                'action' => 'propertydetails',
                                                $proparray['Property']['id']
                                            )));
                    '</td>';
            }
            else
            {
               $output .='<td>'.
                    $this->Html->image('/croogo/img/layout/reservation-desactive.png',array('class' => $classdis));
                    '</td>'; 
            }
        }
        return $output;
    }
   
    public function renderAvailabilityData($notAvailble = null)
    {
       if($notAvailble != null)
       {
           
       }
    }
    
    public function renderPrice($pricedt,$terrain = null)
    {
        $formatprice = '';
        if($terrain == true)
        {
            $formatprice = ' / m²';
        }
        $euro_setting = Configure::read('price.euro');
        //***** verify if the price is null 
            $price_output = '-';
            if ($pricedt != null) {
                $price_output = $pricedt . ' DT'.$formatprice;
                
                $price_output .= ' ~ ' . ceil($pricedt/$euro_setting). ' €'.$formatprice;
         
            } 
        //***** verify if the price is null
            
       return $price_output;
    }

}
