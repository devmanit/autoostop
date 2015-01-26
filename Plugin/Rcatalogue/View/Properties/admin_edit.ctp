<?php
$this->viewVars['title_for_layout'] = __d('croogo', 'Properties');
$this->extend('/Common/admin_edit');

$this->Html
        ->addCrumb('', '/admin', array('icon' => 'home'))
        ->addCrumb(__d('croogo', 'Properties'), array('action' => 'index'));

echo $this->Html->script('/rcatalogue/js/jquery.ui.core.js', array('inline' => false));
echo $this->Html->script('/rcatalogue/js/jquery.ui.datepicker.js', array('inline' => false));
echo $this->Html->script('/rcatalogue/js/jquery-ui.multidatespicker.js', array('inline' => false));
echo $this->Html->css('/rcatalogue/css/mdp.css', null, array('inline' => false));

if ($this->action == 'admin_edit') {
    $this->Html->addCrumb($this->data['Property']['name'], '/' . $this->request->url);
    $this->viewVars['title_for_layout'] = 'Properties: ' . $this->data['Property']['name'];
} else {
    $this->Html->addCrumb(__d('croogo', 'Add'), '/' . $this->request->url);
}

echo $this->Form->create('Property');
?>
<div class="properties row-fluid">
    <div class="span8">
        <ul class="nav nav-tabs">
            <?php
            echo $this->Croogo->adminTab(__d('croogo', 'Détailles'), '#property');
            echo $this->Croogo->adminTab(__d('croogo', 'Villes'), '#property-address');
            echo $this->Croogo->adminTab(__d('croogo', 'Votre itinéraire'), '#property-map');
            echo $this->Croogo->adminTabs();
            ?>
        </ul>

        <div class="tab-content">
            <div id='property' class="tab-pane">
                <?php
                echo $this->Form->input('id');
                $this->Form->inputDefaults(array('label' => false, 'class' => 'span10'));
                
                echo '<table class="table table-striped" style="width:100%;">';
                echo '<thead><tr><td></td><td></td></tr></thead><tbody><tr><td>';
                echo $this->Form->input('datedepart', array(
                    'label' => 'Date de départ',
                    'disabled' => $editable,
                )).'</td><td>';
                echo $this->Form->input('heuredepart', array(
                    'timeFormat' => '24',
                    'label' => 'Heure de départ',
                    'interval' => 5,
                    'disabled' => $editable,
                )).'</td></tr><tr><td>';
                echo $this->Form->input('car_id', array(
                    'label' => 'Voiture',
                    'disabled' => $editable,
                )).'</td><td>';
                echo $this->Form->input('bagage', array(
                    'label' => 'Bagage',
                    'options' => array(
                        'petit' => 'petit',
                        'moyen' => 'moyen',
                        'grand' => 'grand'
                    ),
                    'disabled' => $editable,
                )).'</td></tr></tbody></table>';
                echo $this->Html->beginBox(__d('croogo', 'Conditions'));?>
                <table class="table table-striped">      
                <?php 
                $tableHeaders = $this->Html->tableHeaders(array(
				$this->Form->checkbox('Others.checkAll',array(
                                                      'onchange' => 'checkAll()',
                                                      'disabled' => $editable,
                                )),
                                'Description'
			));
                $array_conditions_values = explode(',', $this->request->data['Property']['spec']);
                ?>
                <thead>
                        <?php echo $tableHeaders; ?>
                </thead>
                <tbody>
                    <tr>
			<td><?php echo $this->Form->checkbox('Conditions.0.id', array('checked' => $array_conditions_values[0],'class' => 'row-select','disabled' => $editable,)); ?></td>
                        <td><span>Espace non-fumeur</span></td>
                    </tr>
                    <tr>
			<td><?php echo $this->Form->checkbox('Conditions.1.id', array('checked' => $array_conditions_values[1],'class' => 'row-select','disabled' => $editable,)); ?></td>
                        <td><span>Air climatisé</span></td>
                    </tr>
                    <tr>
			<td><?php echo $this->Form->checkbox('Conditions.2.id', array('checked' => $array_conditions_values[2],'class' => 'row-select','disabled' => $editable,)); ?></td>
                        <td><span>Pas de support à vélo</span></td>
                    </tr>
                    <tr>
			<td><?php echo $this->Form->checkbox('Conditions.3.id', array('checked' => $array_conditions_values[3],'class' => 'row-select','disabled' => $editable,)); ?></td>
                        <td><span>Pas de support à ski</span></td>
                    </tr>
                    <tr>
			<td><?php echo $this->Form->checkbox('Conditions.4.id', array('checked' => $array_conditions_values[4],'class' => 'row-select','disabled' => $editable,)); ?></td>
                        <td><span>Animaux acceptés</span></td>
                    </tr>
                    <tr>
			<td><?php echo $this->Form->checkbox('Conditions.5.id', array('checked' => $array_conditions_values[5],'class' => 'row-select','disabled' => $editable,)); ?></td>
                        <td><span>Accès au numéro de téléphone du conducteur</span></td>
                    </tr>
                </tbody>
                </table>
                <?php
                echo $this->Html->endBox();
                 ?>
                 
                 
            </div>
            
            <div id='property-address' class="tab-pane">
               <?php
               $array_country = array('Afghanistan','Afrique du Sud','Afrique Centrale','Albanie','Algerie','Allemagne','Andorre','Angola','Anguilla','Arabie Saoudite','Argentine','Armenie','Australie','Autriche','Azerbaidjan','Bahamas','Bangladesh','Barbade','Bahrein','Belgique','Belize','Benin','Bermudes','Bielorussie','Bolivie','Botswana','Bhoutan','Boznie Herzegovine','Bresil','Brunei','Bulgarie','Burkina Faso','Burundi','Caiman','Cambodge','Cameroun','Canada','Canaries','Cap Vert','Chili','Chine','Chypre','Colombie','Colombie','Congo','Congo democratique','Cook','Coree du Nord','Coree du Sud','Costa Rica','Côte d Ivoire','Croatie','Cuba','Danemark','Djibouti','Dominique','Egypte','Emirats Arabes Unis','Equateur','Erythree','Espagne','Estonie','Etats Unis','Ethiopie','Falkland','Feroe','Fidji','Finlande','France','Gabon','Gambie','Georgie','Ghana','Gibraltar','Grece','Grenade','Groenland','Guadeloupe','Guam','Guatemala','Guernesey','Guinee','Guinee Bissau','Guinee Equatoriale','Guyana','Guyane Francaise','Haiti','Hawaii','Honduras','Hong Kong','Hongrie','Inde','Indonesie','Iran','Iraq','Irlande','Islande','Israel','italie','Jamaique','Jan Mayen','Japon','Jersey','Jordanie','Kazakhstan','Kenya','Kirghizistan','Kiribati','Koweit','Laos','Lesotho','Lettonie','Liban','Liberia','Liechtenstein','Lituanie','Luxembourg','Lybie','Macao','Macedoine','Madagascar','Madère','Malaisie','Malawi','Maldives','Mali','Malte','Man','Mariannes du Nord','Maroc','Marshall','Martinique','Maurice','Mauritanie','Mayotte','Mexique','Micronesie','Midway','Moldavie','Monaco','Mongolie','Montserrat','Mozambique','Namibie','Nauru','Nepal','Nicaragua','Niger','Nigeria','Niue','Norfolk','Norvege','Nouvelle Caledonie','Nouvelle Zelande','Oman','Ouganda','Ouzbekistan','Pakistan','Palau','Palestine','Panama','Papouasie Nouvelle Guinee','Paraguay','Pays Bas','Perou','Philippines','Pologne','Polynesie','Porto Rico','Portugal','Qatar','Republique Dominicaine','Republique Tcheque','Reunion','Roumanie','Royaume Uni','Russie','Rwanda','Sahara Occidental','Sainte Lucie','Saint Marin','Salomon','Salvador','Samoa Occidentales','Samoa Americaine','Sao Tome et Principe','Senegal','Seychelles','Sierra Leone','Singapour','Slovaquie','Slovenie','Somalie','Soudan','Sri Lanka','Suede','Suisse','Surinam','Swaziland','Syrie','Tadjikistan','Taiwan','Tonga','Tanzanie','Tchad','Thailande','Tibet','Timor Oriental','Togo','Trinite et Tobago','Tristan de cuncha','Tunisie','Turmenistan','Turquie','Ukraine','Uruguay','Vanuatu','Vatican','Venezuela','Vierges Americaines','Vierges Britanniques','Vietnam','Wake','Wallis et Futuma','Yemen','Yougoslavie','Zambie','Zimbabwe');
               $array_country = array_combine($array_country, $array_country);
               $canada_province = array('--', 'Alberta', 'British ColumbiaManitoba', 'New Brunswick', 'Newfoundland and Labrador', 'Nova Scotia', 'Northwest Territories', 'Nunavut', 'Ontario', 'Prince Edward Island', 'Quebec', 'Saskatchewan', 'Yukon');
               $canada_province = array_combine($canada_province, $canada_province);
                echo '<div class="span6">';
                echo '<table class="table table-striped" style="width:100%;">';
                echo '<thead><tr><td><strong>Adress départ :</strong></td></tr></thead><tbody><tr><td>';
                echo $this->Form->input('PropertyAddress.id',array('value' => $this->request->data['PropertyAddress'][0]['id'],));
                $this->Form->inputDefaults(array('label' => false, 'class' => 'span10'));
                
                echo $this->Form->input('PropertyAddress.country', array(
                    'label' => 'Pays*',
                    'value' => $this->request->data['PropertyAddress'][0]['country'],
                    'disabled' => $editable,
                    'required' => true,
                    'options' => $array_country,
                )).'</td></tr><tr><td>';?>
                <div class="input select">
                <label for="provincedep" id="provincelabel">Province*</label>
                <select id="provincedep" name="data[PropertyAddress][province]"  <?= $editable; ?> class="span10 viewonly" style='display:' required="required">
                    <option class="conditional Canada" value="Alberta">Alberta</option>
                            <option class="conditional Canada" value="British Columbia">Colombie-Britannique</option>
                            <option class="conditional Canada" value="Manitoba">Manitoba</option>
                            <option class="conditional Canada" value="New Brunswick">Nouveau-Brunswick</option>
                            <option class="conditional Canada" value="Newfoundland and Labrador">Terre-neuve et labrador</option>
                            <option class="conditional Canada" value="Nova Scotia">Nouvelle-Écosse</option>
                            <option class="conditional Canada" value="Ontario">Ontario</option>
                            <option class="conditional Canada" value="Prince Edward Island">Ile du Prince-Édouard</option>
                            <option class="conditional Canada" value="Quebec">Québec</option>
                            <option class="conditional Canada" value="Saskatchewan">Saskatchewan</option>
                            <option class="conditional Canada" value="Northwest Territories">Territoire du Nord-Ouest</option>
                            <option class="conditional Canada" value="Nunavut">Nunavut</option>
                            <option class="conditional Canada" value="Yukon">Yukon</option>

                    <option class="conditional USA" value="Alabama">Alabama</option>
                    <option class="conditional USA" value="Alaska">Alaska</option>
                    <option class="conditional USA" value="AZ">Arizona</option>
                    <option class="conditional USA" value="Arizona">Arkansas</option>    
                    <option class="conditional USA" value="California">California</option>    
                    <option class="conditional USA" value="Colorado">Colorado</option>    
                    <option class="conditional USA" value="Connecticut">Connecticut</option>    
                    <option class="conditional USA" value="Delaware">Delaware</option>    
                    <option class="conditional USA" value="District Of Columbia">District Of Columbia</option>    
                    <option class="conditional USA" value="Florida">Florida</option>    
                    <option class="conditional USA" value="Georgia">Georgia</option>    
                    <option class="conditional USA" value="Hawaii">Hawaii</option>    
                    <option class="conditional USA" value="Idaho">Idaho</option>    
                    <option class="conditional USA" value="Illinois">Illinois</option>    
                    <option class="conditional USA" value="Indiana">Indiana</option>    
                    <option class="conditional USA" value="Iowa">Iowa</option>    
                    <option class="conditional USA" value="Kansas">Kansas</option>    
                    <option class="conditional USA" value="Kentucky">Kentucky</option>    
                    <option class="conditional USA" value="Louisiana">Louisiana</option>    
                    <option class="conditional USA" value="Maine">Maine</option>
                    <option class="conditional USA" value="Maryland">Maryland</option>
                    <option class="conditional USA" value="Massachusetts">Massachusetts</option>
                    <option class="conditional USA" value="Michigan">Michigan</option>
                    <option class="conditional USA" value="Minnesota">Minnesota</option>
                    <option class="conditional USA" value="Mississippi">Mississippi</option>
                    <option class="conditional USA" value="Missouri">Missouri</option>
                    <option class="conditional USA" value="Montana">Montana</option>
                    <option class="conditional USA" value="Nebraska">Nebraska</option>    
                    <option class="conditional USA" value="Nevada">Nevada</option>    
                    <option class="conditional USA" value="New Hampshire">New Hampshire</option>    
                    <option class="conditional USA" value="New Jersey">New Jersey</option>    
                    <option class="conditional USA" value="New Mexico">New Mexico</option>
                    <option class="conditional USA" value="New York">New York</option>    
                    <option class="conditional USA" value="North Carolina">North Carolina</option>
                    <option class="conditional USA" value="North Dakota">North Dakota</option>
                    <option class="conditional USA" value="Ohio">Ohio</option>    
                    <option class="conditional USA" value="Oklahoma">Oklahoma</option>
                    <option class="conditional USA" value="Oregon">Oregon</option>
                    <option class="conditional USA" value="Pennsylvania">Pennsylvania</option>
                    <option class="conditional USA" value="Rhode Island">Rhode Island</option>
                    <option class="conditional USA" value="South Carolina">South Carolina</option>
                    <option class="conditional USA" value="South Dakota">South Dakota</option>
                    <option class="conditional USA" value="Tennessee">Tennessee</option>
                    <option class="conditional USA" value="Texas">Texas</option>
                    <option class="conditional USA" value="Utah">Utah</option>
                    <option class="conditional USA" value="Vermont">Vermont</option>    
                    <option class="conditional USA" value="Virginia">Virginia</option>
                    <option class="conditional USA" value="Washington">Washington</option>    
                    <option class="conditional USA" value="West Virginia">West Virginia</option>    
                    <option class="conditional USA" value="Wisconsin">Wisconsin</option>
                    <option class="conditional USA" value="Wyoming">Wyoming</option>
                </select>
                </div>
                </td></tr><tr><td>
                <?php
                
                 echo $this->Form->input('PropertyAddress.city', array(
                    'label' => 'Ville*',
                     'value' => $this->request->data['PropertyAddress'][0]['city'],
                     'disabled' => $editable,
                     'required' => true,
                )).'</td></tr>';
                 
                 echo '<tr><td>'.$this->Form->input('PropertyAddress.line_address', array(
                     'value' => $this->request->data['PropertyAddress'][0]['line_address'],
                     'disabled' => $editable,
                     'required' => true,
                     'placeholder' => 'Plus de détailles sur votre adresse de départ',
                    'label' => 'Description de l\'adresse de départ*','required' => true
                )).'</td></tr>';
               
                 echo '</tbody></table></div>';
                 
                 
               
                
                echo '<div class="span6">';
                echo '<table class="table table-striped" style="width:100%;">';
                echo '<thead><tr><td><strong>Adress arrivé :</strong></td></tr></thead><tbody><tr><td>';
                
                echo $this->Form->input('PropertyAddress.country_des', array(
                    'label' => 'Pays*',
                    'value' => $this->request->data['PropertyAddress'][0]['country_des'],
                    'disabled' => $editable,
                    'required' => true,
                    'options' => $array_country,
                )).'</td></tr><tr><td>';?>
                 
                <div class="input select">
                <label for="provincedes" id='provincelabeldes'>Province*</label>
                <select id="provincedes" name="data[PropertyAddress][province_des]" <?= $editable; ?> class="span10 viewonly" style='display:' required="required">
                    <option class="conditional Canada" selected="selected" value="<?=$this->request->data['PropertyAddress'][0]['province_des']?>"><?=$this->request->data['PropertyAddress'][0]['province_des']?></option>
                    <option class="conditional Canada" value="Alberta">Alberta</option>
                            <option class="conditional Canada" value="British Columbia">Colombie-Britannique</option>
                            <option class="conditional Canada" value="Manitoba">Manitoba</option>
                            <option class="conditional Canada" value="New Brunswick">Nouveau-Brunswick</option>
                            <option class="conditional Canada" value="Newfoundland and Labrador">Terre-neuve et labrador</option>
                            <option class="conditional Canada" value="Nova Scotia">Nouvelle-Écosse</option>
                            <option class="conditional Canada" value="Ontario">Ontario</option>
                            <option class="conditional Canada" value="Prince Edward Island">Ile du Prince-Édouard</option>
                            <option class="conditional Canada" value="Quebec">Québec</option>
                            <option class="conditional Canada" value="Saskatchewan">Saskatchewan</option>
                            <option class="conditional Canada" value="Northwest Territories">Territoire du Nord-Ouest</option>
                            <option class="conditional Canada" value="Nunavut">Nunavut</option>
                            <option class="conditional Canada" value="Yukon">Yukon</option>

                    <option class="conditional USA" value="Alabama">Alabama</option>
                    <option class="conditional USA" value="Alaska">Alaska</option>
                    <option class="conditional USA" value="AZ">Arizona</option>
                    <option class="conditional USA" value="Arizona">Arkansas</option>    
                    <option class="conditional USA" value="California">California</option>    
                    <option class="conditional USA" value="Colorado">Colorado</option>    
                    <option class="conditional USA" value="Connecticut">Connecticut</option>    
                    <option class="conditional USA" value="Delaware">Delaware</option>    
                    <option class="conditional USA" value="District Of Columbia">District Of Columbia</option>    
                    <option class="conditional USA" value="Florida">Florida</option>    
                    <option class="conditional USA" value="Georgia">Georgia</option>    
                    <option class="conditional USA" value="Hawaii">Hawaii</option>    
                    <option class="conditional USA" value="Idaho">Idaho</option>    
                    <option class="conditional USA" value="Illinois">Illinois</option>    
                    <option class="conditional USA" value="Indiana">Indiana</option>    
                    <option class="conditional USA" value="Iowa">Iowa</option>    
                    <option class="conditional USA" value="Kansas">Kansas</option>    
                    <option class="conditional USA" value="Kentucky">Kentucky</option>    
                    <option class="conditional USA" value="Louisiana">Louisiana</option>    
                    <option class="conditional USA" value="Maine">Maine</option>
                    <option class="conditional USA" value="Maryland">Maryland</option>
                    <option class="conditional USA" value="Massachusetts">Massachusetts</option>
                    <option class="conditional USA" value="Michigan">Michigan</option>
                    <option class="conditional USA" value="Minnesota">Minnesota</option>
                    <option class="conditional USA" value="Mississippi">Mississippi</option>
                    <option class="conditional USA" value="Missouri">Missouri</option>
                    <option class="conditional USA" value="Montana">Montana</option>
                    <option class="conditional USA" value="Nebraska">Nebraska</option>    
                    <option class="conditional USA" value="Nevada">Nevada</option>    
                    <option class="conditional USA" value="New Hampshire">New Hampshire</option>    
                    <option class="conditional USA" value="New Jersey">New Jersey</option>    
                    <option class="conditional USA" value="New Mexico">New Mexico</option>
                    <option class="conditional USA" value="New York">New York</option>    
                    <option class="conditional USA" value="North Carolina">North Carolina</option>
                    <option class="conditional USA" value="North Dakota">North Dakota</option>
                    <option class="conditional USA" value="Ohio">Ohio</option>    
                    <option class="conditional USA" value="Oklahoma">Oklahoma</option>
                    <option class="conditional USA" value="Oregon">Oregon</option>
                    <option class="conditional USA" value="Pennsylvania">Pennsylvania</option>
                    <option class="conditional USA" value="Rhode Island">Rhode Island</option>
                    <option class="conditional USA" value="South Carolina">South Carolina</option>
                    <option class="conditional USA" value="South Dakota">South Dakota</option>
                    <option class="conditional USA" value="Tennessee">Tennessee</option>
                    <option class="conditional USA" value="Texas">Texas</option>
                    <option class="conditional USA" value="Utah">Utah</option>
                    <option class="conditional USA" value="Vermont">Vermont</option>    
                    <option class="conditional USA" value="Virginia">Virginia</option>
                    <option class="conditional USA" value="Washington">Washington</option>    
                    <option class="conditional USA" value="West Virginia">West Virginia</option>    
                    <option class="conditional USA" value="Wisconsin">Wisconsin</option>
                    <option class="conditional USA" value="Wyoming">Wyoming</option>
                </select>
                </div>
                </td></tr><tr><td> 
                 <?php
                 echo $this->Form->input('PropertyAddress.city_des', array(
                    'label' => 'Ville*',
                     'value' => $this->request->data['PropertyAddress'][0]['city_des'],
                     'disabled' => $editable,
                     'required' => true,
                )).'</td></tr>';
                 
                 
                 echo '<tr><td>'.$this->Form->input('PropertyAddress.line_address_des', array(
                     'value' => $this->request->data['PropertyAddress'][0]['line_address_des'],
                     'disabled' => $editable,
                     'placeholder' => 'Plus de détailles sur votre adresse d\'arrivée',
                     'required' => true,
                    'label' => 'Description de l\'adresse d\'arrivée*','required' => true
                )).'</td></tr>';
               
                 echo '</tbody></table></div>';
               
                  ?>
            </div>
            <div id='property-map' class="tab-pane">
               <!-- First map -->
                <div class="span6">
                     <strong>Rendez-vous à :</strong>
                        <fieldset class="gllpLatlonPicker">
                            <input type="text" class="gllpSearchField">
                            <input  type="button" class="gllpSearchButton btn" value="search">
                            <div id="mapdepart" class="gllpMap">Google Maps</div>
                            <br/>
                            <table class="table table-striped" style="width:100%;">
                                <tr>
                                    <th>Latitude</th>
                                    <th>Longitude</th>
                                    <th>Zoom</th>
                                    <th></th>
                                </tr>
                                <tr>
                                    <td>
                                        <input <?= $editable; ?> type="number" id="PropertyAddressLatitude" step="any" style="width:100%;" class="gllpLatitude" name="data[PropertyAddress][latitude]" required="required" value="<?= $this->request->data['PropertyAddress'][0]['latitude']?>">
                                    </td>
                                    <td>
                                        <input <?= $editable; ?> type="number" id="PropertyAddressLongitude" step="any" style="width:100%;" class="gllpLongitude" name="data[PropertyAddress][longitude]" required="required" value="<?= $this->request->data['PropertyAddress'][0]['longitude']?>">
                                    </td>
                                    <td>
                                        <input <?= $editable; ?> type="number" id="PropertyAddressZoom" style="width:100%;" class="gllpZoom" name="data[PropertyAddress][zoom]" required="required" value="<?= $this->request->data['PropertyAddress'][0]['zoom']?>">
                                    </td>
                                    <td>
                                       <input <?= $editable; ?> type="button" class="gllpUpdateButton btn" value="Valider">
                                    </td> </tr></table>
                            <br/>

                        </fieldset>
                        
                     </div>
                 <!-- Second map -->
                 <div class="span6">
                     <strong>Point de chute à :</strong>
                        <fieldset class="gllpLatlonPicker">
                            <input type="text" class="gllpSearchField">
                            <input  type="button" class="gllpSearchButton btn" value="search">
                            <div id="maparrive" class="gllpMap">Google Maps</div>
                            <br/>
                            <table class="table table-striped" style="width:100%;">
                                <tr>
                                    <th>Latitude</th>
                                    <th>Longitude</th>
                                    <th>Zoom</th>
                                    <th></th>
                                </tr>
                                <tr>
                                    <td>
                                        <input <?= $editable; ?> type="number" id="PropertyAddressLatitudeDes" step="any" style="width:100%;" class="gllpLatitude" name="data[PropertyAddress][latitude_des]" required="required" value="<?= $this->request->data['PropertyAddress'][0]['latitude_des'];?>">
                                    </td>
                                    <td>
                                        <input <?= $editable; ?> type="number" id="PropertyAddressLongitudeDes" step="any" style="width:100%;" class="gllpLongitude" name="data[PropertyAddress][longitude_des]" required="required" value="<?= $this->request->data['PropertyAddress'][0]['longitude_des'];?>">
                                    </td>
                                    <td>
                                        <input <?= $editable; ?> type="number" id="PropertyAddressZoomDes" style="width:100%;" class="gllpZoom" name="data[PropertyAddress][zoom_des]" required="required" value="<?= $this->request->data['PropertyAddress'][0]['zoom_des'];?>">
                                    </td>
                                    <td>
                                       <input <?= $editable; ?> type="button" class="gllpUpdateButton btn" value="Valider">
                                    </td> </tr></table>
                            <br/>

                        </fieldset>
                        
                     </div>
                     
            </div>
            <?php echo $this->Croogo->adminTabs(); ?>
        </div>

    </div>

    <div class="span4">
        <?php
        echo $this->Html->beginBox('');
        if(isset($editable) && $editable != 'disabled')
        {
        echo $this->Form->button(__d('croogo', 'Apply'), array('name' => 'apply'));
        }
        if(isset($error))
        {
       echo '<hr />';
       foreach ($error as $value) {
           if(isset($value) && $value != null){
               echo '<div class="error">';
               echo $value.'</div>';
           }
               }
        }
        echo '<hr /><table class="table table-striped" style="width:100%;">
                            <tr>
                                    <th class="span6">Prix*</th>
                                    <th class="span6">Devis</th>
                            </tr>
                            <tr>
                                <td>' .
        $this->Form->input('pricedt', array(
            'disabled' => $editable,
            'style' => 'width:100%;margin-left:0;'
        )) .
        '</td>
                                 <td>' .
        $this->Form->input('devis', array(
            'options' => array('dollar_canada' => '$ Canadian',
                               'dollar_usa' => '$ Américan'),
            'disabled' => $editable,
            'style' => 'width:100%;',
        )) .
        '</td>
                            </tr>
                        </table>' .
        '<table class="table table-striped" style="width:100%;">
                            <tr>
                                    <th>Nombre de place*</th>
                            </tr>
                            <tr>
                                <td>' .
        $this->Form->input('rooms', array(
            'disabled' => $editable,
            'style' => 'width:100%;',
        )) .
        '</td>
                            </tr>
                        </table>'.
        $this->Html->endBox();

        ?>

    </div>

</div>
<?php echo $this->Form->end(); ?>

<script type='text/javascript'>
    
    function checkAll()
    {
      d = document.getElementById("OthersCheckAll").checked;
      if(d === true)
      {
          document.getElementById("Conditions0Id").checked = true;
          document.getElementById("Conditions1Id").checked = true;
          document.getElementById("Conditions2Id").checked = true;
          document.getElementById("Conditions3Id").checked = true;
          document.getElementById("Conditions4Id").checked = true;
          document.getElementById("Conditions5Id").checked = true;
      }
      else
      {
          document.getElementById("Conditions0Id").checked = false;
          document.getElementById("Conditions1Id").checked = false;
          document.getElementById("Conditions2Id").checked = false;
          document.getElementById("Conditions3Id").checked = false;
          document.getElementById("Conditions4Id").checked = false;
          document.getElementById("Conditions5Id").checked = false;
      }
    }
    // "Generic" function
    $.conditionalize = function (sourceSelect, conditionalSelect) {
        var options = conditionalSelect.children(".conditional").clone();

        sourceSelect.change(function () {
            var value = $(this).val();
            if(value != 'Canada' && value != 'USA')
            {
             conditionalSelect.children(".conditional").remove();
             options.clone().filter("." + value).appendTo(conditionalSelect);
             document.getElementById("provincedep").style.display="none";
             document.getElementById("provincelabel").style.display="none";
            }
            else
            {
            conditionalSelect.children(".conditional").remove();
            options.clone().filter("." + value).appendTo(conditionalSelect);
            document.getElementById("provincedep").style.display="";
             document.getElementById("provincelabel").style.display="";
            }
            
        }).trigger("change");
    }
    $.conditionalizedes = function (sourceSelect, conditionalSelect) {
        var options = conditionalSelect.children(".conditional").clone();

        sourceSelect.change(function () {
            var value = $(this).val();
            if(value != 'Canada' && value != 'USA')
            {
             conditionalSelect.children(".conditional").remove();
             options.clone().filter("." + value).appendTo(conditionalSelect);
             document.getElementById("provincedes").style.display="none";
             document.getElementById("provincelabeldes").style.display="none";
            }
            else
            {
            conditionalSelect.children(".conditional").remove();
            options.clone().filter("." + value).appendTo(conditionalSelect);
            document.getElementById("provincedes").style.display="";
             document.getElementById("provincelabeldes").style.display="";
            }
            
        }).trigger("change");
    }
    // Used like this:
    $.conditionalize($("#PropertyAddressCountry"), $("#provincedep"));
    $.conditionalizedes($("#PropertyAddressCountryDes"), $("#provincedes"));
    
    $(function() {
    var availableTags = [
    "Abbotsford, CANADA","Acadie, CANADA","Acton, CANADA","AEROPUERTO MONTREAL P. ELLIOTT, CANADA","Agassiz, BC, CANADA","Ainsworth, CANADA","Airdrie, AB, CANADA","Ajax, ON, CANADA","Alberta, CANADA","Alberton, PE, CANADA","Aldergrove, BC, CANADA","Alert Bay, BC, CANADA","Algonquin Highlands, ON, CANADA","Algonquin Park, CANADA","Alliston, CANADA","Alma, CANADA","Alton, CANADA","Amethyst Harbour, ON, CANADA","Amherst, NS, CANADA","Amos, CANADA","Amqui, QC, CANADA","Ancaster, CANADA","Angers, QC, CANADA","Angus, ON, CANADA","Anjou, CANADA","ANNAPOLIS ROYAL, NS, CANADA","Anse au Griffon, QC, CANADA","Antigonish, CANADA","Apex Mountain, BC, CANADA","Armstrong, BC, CANADA","Arnprior, CANADA","Asbestos, QC, CANADA","Ashcroft, BC, CANADA","Assiniboia, SK, CANADA","Athabasca, CANADA","Aurora, ON, CANADA","Ayer Cliff, CANADA","Baddeck, CANADA","Baddeck Inlet, NS, CANADA","Baie Sainte-Catherine, CANADA","Baie-Comeau, CANADA","Baie-Saint-Paul, QC, CANADA","Bancroft, ON, CANADA","Banff, CANADA","Barrie, CANADA","Barriere, CANADA","Basswood, MB, CANADA","Bathurst, CANADA","Bay Fortune, PE, CANADA","Bayfield, CANADA","Beaumont, QC, CANADA","Beauport, CANADA","Beaupre, CANADA","Beausejour, CANADA","Beaver Creek, CANADA","Beaver Creek, Yukon, CANADA","Beaverfoot, BC, CANADA","Becancour, CANADA","Bedeque, PE, CANADA","Bedford, NS, CANADA","Belleville, CANADA","Belleville, ON, CANADA","Belwood, ON, CANADA","Beresford, CANADA","Berthier-sur-Mer, QC, CANADA","Berthierville, CANADA","Bertrand, NB, CANADA","Berwick, NS, CANADA","Bewdley, ON, CANADA","Bic, QC, CANADA","Big White Ski Resort, CANADA","Birch Plain, NS, CANADA","Blainville, CANADA","Blairmore, CANADA","Blind Bay, BC, CANADA","Blind River, ON, CANADA","Bloomfield, ON, CANADA","Blue Mountains, ON, CANADA","Blue River, CANADA","Bobcaygeon, ON, CANADA","Bocabec, NB, CANADA","Boischatel, CANADA","Bolton-Est, QC, CANADA","Bonaventure, CANADA","Bonnyville, CANADA","Botwood, NL, CANADA","Boucherville, CANADA","Bouctouche, CANADA","Boularderie East, NS, CANADA","Bowen Island, BC, CANADA","Bowmanville, CANADA","BOWSER, CANADA","Bracebridge, CANADA","Brackendale, BC, CANADA","Brackley Beach, PE, CANADA","Brandon, CANADA","Brantford, CANADA","Brentwood Bay, CANADA","Brew Bay, BC, CANADA","Bridge Lake, BC, CANADA","Bridgetown, NS, CANADA","Bridgewater, CANADA","Brighton, ON, CANADA","Brisco, CANADA","Bristol, NB, CANADA","BRITISH COLUMBIA, CANADA","Broadview, SK, CANADA","Brockville, CANADA","Bromont, CANADA","Brooklin, ON, CANADA","Brooks, CANADA","Brossard, CANADA","Brownsburg, CANADA","Buckhorn, CANADA","Buckingham, QC, CANADA","Bugaboo Provincial Park, BC, CANADA","Burlington, ON, CANADA","Burnaby, BC, CANADA","Cabano, CANADA","Cache Creek, CANADA","Calabogie, CANADA","Calgary, AB, CANADA","Callander, ON, CANADA","Cambridge, ON, CANADA","Campbell River, CANADA","Campbellford, ON, CANADA","Campbellton, CANADA","Campbellville, ON, CANADA","Camrose, CANADA","Canmore, CANADA","Canning, NS, CANADA","Cap-aux-Meules, QC, CANADA","Cap-Chat, QC, CANADA","Cap-des-Rosiers, QC, CANADA","Caplan, QC, CANADA","Cap-Saint-Ignace, QC, CANADA","Caraquet, CANADA","Carbonear, NL, CANADA","Cardiff, ON, CANADA","Cardigan, CANADA","Carleton Place, ON, CANADA","Carleton, QC, CANADA","Carlyle, SK, CANADA","Carnarvon, ON, CANADA","Carrs Landing, BC, CANADA","Castle Junction, AB, CANADA","Castlegar, CANADA","Cavendish, PE, CANADA","Cayamant, QC, CANADA","Centreville, NS, CANADA","Chambly, QC, CANADA","Chambord, QC, CANADA","Champlain, QC, CANADA","Chandler, QC, CANADA","Channel-Port aux Basques, NL, CANADA","Charette, QC, CANADA","Charlevoix, CANADA","Charlottetown, NL, CANADA","Charlottetown, Pe, CANADA","Chase, BC, CANADA","Chateau Richer, QC, CANADA","Chatham, CANADA","Chemainus, CANADA","Cheticamp, NS, CANADA","Chetwynd, CANADA","Chicoutimi, QC, CANADA","Chilliwack, BC, CANADA","Christina Lake, BC, CANADA","Christina, BC, CANADA","Christopher Lake, SK, CANADA","Churchill, MB, CANADA","Clairmont, CANADA","Clarenville, NL, CANADA","Claresholm, CANADA","Clearwater, CANADA","Clearwater Lodge, BC, CANADA","Clinton, BC, CANADA","Coal Harbour, BC, CANADA","Cobble Hill, BC, CANADA","Cobourg, CANADA","Cochrane, AB, CANADA","Cochrane, ON, CANADA","Colborne, ON, CANADA","Cold Lake, CANADA","Coleman, AB, CANADA","Collingwood, CANADA","Comox, CANADA","Compton, QC, CANADA","Coniston, ON, CANADA","Conklin, AB, CANADA","Cookstown, CANADA","Cookville, NS, CANADA","Coquitlam, CANADA","Corner Brook, CANADA","Cornwall, CANADA","Cornwall, ON, CANADA","Courtenay, CANADA","Cowansville, CANADA","Cowichan Bay, CANADA","Cranbrook, CANADA","Crawford Bay, BC, CANADA","Creemore, ON, CANADA","Creston, BC, CANADA","Crofton, BC, CANADA","Cumberland, BC, CANADA","Cymbria, PE, CANADA","Dalhousie, CANADA","Danville, QC, CANADA","Dartmouth, CANADA","Dauphin, CANADA","Dawson City, CANADA","Dawson Creek, CANADA","Dead Mans Flats, AB, CANADA","Dease Lake, BC, CANADA","Deer Lake, CANADA","Deer Lake, NF, CANADA","Delhi, ON, CANADA","Delta, CANADA","Denholm, QC, CANADA","Denman Island, BC, CANADA","Depot de l'Ile, QC, CANADA","Deschambault, QC, CANADA","Devon, AB, CANADA","Didsbury, AB, CANADA","Dieppe, NB, CANADA","Digby, CANADA","Dildo, NF, CANADA","Dolbeau, QC, CANADA","Dorset, CANADA","Dorval, CANADA","Downsview, CANADA","Drayton Valley, CANADA","Drayton, ON, CANADA","Drumheller, CANADA","Drummondville, CANADA","Dryden, CANADA","Duhamel, QC, CANADA","Duncan, CANADA","Dundas, ON, CANADA","Dunnville, ON, CANADA","Duntroon, ON, CANADA","Dwight, ON, CANADA","Eagle Lake, ON, CANADA","East Kelowna, BC, CANADA","Eastman, QC, CANADA","Edgetts Landing, NB, CANADA","Edmonton, AB, CANADA","Edmundston, CANADA","Edson, AB, CANADA","Eganville, CANADA","Egmont, BC, CANADA","Elk Point, AB, CANADA","Elkwater, AB, CANADA","Elliot Lake, CANADA","Elliot Lake, ON, CANADA","Elora, CANADA","Enderby, CANADA","Enfield, NS, CANADA","Ennismore, ON, CANADA","Enoch, CANADA","Entrelacs, QC, CANADA","Esterel, CANADA","Esterel, QC, CANADA","Esterhazy, SK, CANADA","Estevan, CANADA","Etang-du-Nord, QC, CANADA","Etobicoke, CANADA","Exshaw, CANADA","Fairhaven, NB, CANADA","FAIRMONT HOT SPRINGS, CANADA","Fall River, CANADA","Fatima, QC, CANADA","Fenelon Falls, ON, CANADA","Fergus, ON, CANADA","Ferme-Neuve, QC, CANADA","Fernie, CANADA","Fernwood, BC, CANADA","Field, CANADA","Flesherton, ON, CANADA","Foresters Falls, ON, CANADA","Forestville, CANADA","Fort Coulonge, QC, CANADA","Fort Erie, CANADA","Fort Frances, CANADA","Fort Macleod, AB, CANADA","Fort McMurray, CANADA","Fort Nelson, BC, CANADA","Fort Saint John, BC, CANADA","Fort Saskatchewan, CANADA","FORTERIE, CANADA","Fortune, NL, CANADA","Fox Creek, CANADA","Franquelin, QC, CANADA","Fredericton, CANADA","Frelighsburg, QC, CANADA","French River, PE, CANADA","French Village, CANADA","Fulford Harbour, BC, CANADA","Furry Creek, BC, CANADA","Gabriola, BC, CANADA","Galiano Island, BC, CANADA","Gananoque, CANADA","Gander, CANADA","Ganges, BC, CANADA","Gannon Village, ON, CANADA","Garden Bay, BC, CANADA","Garibaldi, BC, CANADA","Gaspe, QC, CANADA","Gatineau-Ottawa, QC, CANADA","Genelle, BC, CANADA","Georgetown, CANADA","Georgina, ON, CANADA","Gibsons, BC, CANADA","Gilmour, ON, CANADA","Gimli, CANADA","Godbout, QC, CANADA","Goderich, ON, CANADA","Goffs, CANADA","Gold Bridge, BC, CANADA","Gold River, BC, CANADA","Golden, CANADA","GORE BAY, ON, CANADA","Goulais River, ON, CANADA","Grafton, ON, CANADA","Granby, QC, CANADA","Grand Cache, AB, CANADA","Grand Falls, CANADA","Grand Falls Windsor, NF, CANADA","Grand Forks, CANADA","Grand pre, NS, CANADA","Grande Cache, CANADA","Grande Prairie, AB, CANADA","Grande Vallee, QC, CANADA","Grande-Ligne, QC, CANADA","Grande-Riviere, QC, CANADA","Grandes-Bergeronnes, QC, CANADA","Grandes-Piles, QC, CANADA","Grand-Mere, QC, CANADA","Granville Ferry, NS, CANADA","Gravenhurst, CANADA","Greenfield Park, QC, CANADA","Greenwich, CANADA","Grenville sur la Rouge, QC, CANADA","Grimsby, CANADA","Grimshaw, AB, CANADA","Guelph, ON, CANADA","Guildford, BC, CANADA","Hacketts Cove, NS, CANADA","HAGENSBORG, CANADA","Haines Junction, YT, CANADA","Halfmoon Bay, CANADA","Haliburton, CANADA","Halifax, NS, CANADA","Ham Nord, QC, CANADA","Hamilton, CANADA","Hampton, NB, CANADA","Hampton, ON, CANADA","Hanceville, BC, CANADA","Hanna, CANADA","Hanover, ON, CANADA","Harcourt, ON, CANADA","Harrison Hot Springs, CANADA","Harrison Mills, BC, CANADA","Harvie Heights, AB, CANADA","Haute Aboujagane, NB, CANADA","Havre aux Maisons, QC, CANADA","Havre-Aubert, QC, CANADA","Hawkesbury, CANADA","Hay River, NT, CANADA","Headingley, MB, CANADA","Hearst, ON, CANADA","Hebertville, QC, CANADA","Hecla Island, CANADA","Hemlock Valley, BC, CANADA","Heriot Bay, BC, CANADA","Herouxville, QC, CANADA","High Level, CANADA","High Prairie, AB, CANADA","High River, CANADA","Hinton, CANADA","Holyrood, NL, CANADA","Honey Harbor, ON, CANADA","Hope, CANADA","Hopewell Cape, NB, CANADA","Hornby Island, BC, CANADA","Houston, BC, CANADA","Hubbards, NS, CANADA","Hudson's Hope, BC, CANADA","Humboldt, SK, CANADA","Hunts Point, NS, CANADA","Huntsville, CANADA","Ile-Perrot, QC, CANADA","Iles de la Madeleine, QC, CANADA","Indian Brook, NS, CANADA","Ingersoll, CANADA","Ingonish, CANADA","Ingonish Beach, CANADA","Innisfail, CANADA","Inuvik, CANADA","Invermere, CANADA","Iqaluit, CANADA","Iron Bridge, ON, CANADA","Isle Aux Coudres, CANADA","Jacksons Point, ON, CANADA","Jasper National Park, AB, CANADA","Jasper, AB, CANADA","Jesmond, CANADA","Johnston Canyon, AB, CANADA","Johnstown, ON, CANADA","Joliette, QC, CANADA","Jonquiere, CANADA","Jordan, CANADA","Jordan Station, ON, CANADA","Kamloops, CANADA","Kamouraska, QC, CANADA","Kananaskis Village, CANADA","Kanata, ON, CANADA","Kapuskasing, CANADA","KEENE, ON, CANADA","Kelowna, CANADA","Kemptville, CANADA","Kenora, CANADA","Kenosee Park, SK, CANADA","Kensington, PE, CANADA","Killarney, ON, CANADA","Kimberley, CANADA","KIMBERLEY, BC, CANADA","Kimberly, CANADA","Kincardine, CANADA","Kindersley, CANADA","King City, CANADA","Kingsclear, NB, CANADA","Kingston, CANADA","Kingston, NS, CANADA","Kingsville, ON, CANADA","Kirkland Lake, CANADA","Kitchener, CANADA","Kitimat, BC, CANADA","Kleena Kleene, BC, CANADA","LʼAnse-Saint-Jean, QC, CANADA","LʼAssomption, QC, CANADA","L?Islet, QC, CANADA","La Baie, CANADA","La Conception, QC, CANADA","La Guadeloupe, QC, CANADA","La Perade, QC, CANADA","La Tuque, QC, CANADA","Labelle, CANADA","LAC BEAUPORT, CANADA","Lac Delage, CANADA","Lac La Biche, AB, CANADA","Lac La Hache, BC, CANADA","Lac-Etchemin, QC, CANADA","Lachenaie, QC, CANADA","Lac-Megantic, QC, CANADA","Lacombe, AB, CANADA","Lac-Saguay, QC, CANADA","Lac-Simon, QC, CANADA","Lac-Superieur, QC, CANADA","Ladysmith, BC, CANADA","Lake Brome, CANADA","Lake Country, CANADA","Lake Cowichan, BC, CANADA","Lake Edouard, QC, CANADA","Lake Louise, CANADA","Lake Louise Ski Area, CANADA","Lakefield, ON, CANADA","Lakeside, CANADA","Lakeville, NB, CANADA","L'Ancienne-Lorette, QC, CANADA","L'Ange-Gardien, QC, CANADA","Langford, BC, CANADA","Langley, CANADA","Lanigan, SK, CANADA","Lanoraie, CANADA","Lansdowne, ON, CANADA","Lantzville, BC, CANADA","Larouche, QC, CANADA","Laval, CANADA","Le Bic, CANADA","Leamington, ON, CANADA","Les Eboulements, QC, CANADA","Les Escoumins,QC, CANADA","Lethbridge, CANADA","Levis, CANADA","Lillooet, BC, CANADA","Lindsay, ON, CANADA","Liscomb, NS, CANADA","Little Current, ON, CANADA","Little Pond, PE, CANADA","Lively, CANADA","Liverpool, NS, CANADA","Lloydminster, CANADA","London (Londres), CANADA","Lone Butte, BC, CANADA","Long Harbour, BC, CANADA","Long Sault, ON, CANADA","Longueuil, CANADA","L'Orignal, ON, CANADA","Louisbourg, NS, CANADA","Louiseville, QC, CANADA","Lund, BC, CANADA","Lunenburg, NS, CANADA","Lytton, BC, CANADA","Mactier, ON, CANADA","Madeira Park, BC, CANADA","Magdalen Islands, CANADA","Magog, CANADA","Mahone Bay, NS, CANADA","Malahat, CANADA","Malakwa, BC, CANADA","Malbaie (La Malbaie), CANADA","Malignant Cove, NS, CANADA","Manitouwadge, ON, CANADA","Maniwaki, QC, CANADA","Manning Provincial Park, CANADA","Mansons Landing, BC, CANADA","Mansonville, QC, CANADA","Maple Ridge District Municipality, BC, CANADA","Marathon, CANADA","Margaree Forks, CANADA","Margaree Harbour, NS, CANADA","MARIA, QC, CANADA","Marieville, QC, CANADA","Markham, CANADA","Marmora, ON, CANADA","Maryhill, ON, CANADA","Mashteuiatsh, QC, CANADA","Massey, ON, CANADA","Matane, CANADA","Mavilette, NS, CANADA","Mayfield, CANADA","Mayne Island, BC, CANADA","McBride, CANADA","McKerrow, ON, CANADA","Meadow Lake, CANADA","Meaford, ON, CANADA","Medicine Hat, CANADA","Meldrum Bay, ON, CANADA","Melfort, CANADA","Melville, SK, CANADA","Membertou, NS, CANADA","Merrickville, CANADA","Merritt, CANADA","Metabetchouan, QC, CANADA","Metchosin, BC, CANADA","Metis Beach, QC, CANADA","Midland, CANADA","Mile House, BC, CANADA","Mile Ranch, CANADA","Milford, ON, CANADA","Mill Bay, BC, CANADA","Mille Isles, QC, CANADA","Mille-Isles, QC, CANADA","Milton, CANADA","Mindemoya, ON, CANADA","Minden, ON, CANADA","Minett, ON, CANADA","Mirabel, QC, CANADA","Miramichi, NB, CANADA","Miscouche, PE, CANADA","Mission, BC, CANADA","Mississauga, CANADA","Moncton, CANADA","Mont Tremblant, QC, CANADA","Montague, CANADA","Monte Creek, BC, CANADA","Montebello, CANADA","Mont-Laurier, QC, CANADA","Montmagny, CANADA","Montreal (Montréal), CANADA","Montreal (Vieux Montreal), QC, CANADA","Mont-Saint-Hilaire, QC, CANADA","Moose Jaw, CANADA","Moosomin, SK, CANADA","Morden, CANADA","Morell, PE, CANADA","Morin Heights, QC, CANADA","Morley, CANADA","Mount Hope, CANADA","Mount Pearl Park, NL, CANADA","Mount Robson, BC, CANADA","Mount Washington, BC, CANADA","Mountain View, AB, CANADA","Mouth of Keswick, NB, CANADA","Mt. Tremblant, QC, CANADA","Murray Harbour, PE, CANADA","Muskoka, CANADA","Nakusp, BC, CANADA","Nanaimo, CANADA","Nanoose Bay, CANADA","Napanee, CANADA","Naramata, BC, CANADA","Neepawa, MB, CANADA","Nelson, BC, CANADA","Nepean, CANADA","New Carlisle, QC, CANADA","New Glasgow, NS, CANADA","New Hamburg, ON, CANADA","NEW HAZELTON, CANADA","New Liskeard, CANADA","New Minas, CANADA","New Richmond, QC, CANADA","New Westminster, CANADA","Newmarket, CANADA","Niagara Falls, ON, CANADA","Niagara-On-The-Lake, CANADA","Niagara-on-the-Lake, ON, CANADA","Nicolet, QC, CANADA","Nipawin, SK, CANADA","Nipissing Beach, ON, CANADA","Nominingue, CANADA","Norris Point, NL, CANADA","North Battleford, CANADA","North Bay, CANADA","North Hatley, CANADA","North Rustico, PE, CANADA","North Saanich, BC, CANADA","North Sydney, CANADA","North Vancouver, CANADA","North York, CANADA","Norwich, ON, CANADA","Notre-Dame-Des-Bois, QC, CANADA","Notre-Dame-du-Lac, QC, CANADA","Notre-Dame-du-Portage, QC, CANADA","Nottawa, ON, CANADA","NOVA SCOTIA, CANADA","O`Leary, PE, CANADA","Oakville, ON, CANADA","Oka, QC, CANADA","Okanagan Falls, BC, CANADA","Okotoks, CANADA","Old Chelsea, QC, CANADA","Old Québec City, QC, CANADA","Olds, CANADA","Oliver, BC, CANADA","Omemee, ON, CANADA","Onanole, CANADA","One Hundred Mile House, BC, CANADA","Onoway, AB, CANADA","Ontario, CANADA","Orangedale, NS, CANADA","Orangeville, CANADA","Orford, CANADA","Orillia, CANADA","Orleans, ON, CANADA","Oro-Medonte, ON, CANADA","Oromocto, CANADA","Orono, ON, CANADA","Oshawa, CANADA","Osoyoos, CANADA","Ottawa, ON, CANADA","Otter Lake, ON, CANADA","Owen Sound, CANADA","Oxbow, SK, CANADA","Oxtongue Lake, ON, CANADA","Oyen, CANADA","Oyster Bay, BC, CANADA","Oyster River, ВС, CANADA","Padoue, QC, CANADA","Panorama, CANADA","Papineauville, QC, CANADA","Parksville, BC, CANADA","Parrsboro, NS, CANADA","Parry Sound, ON, CANADA","Parson, BC, CANADA","Paspebiac, QC, CANADA","Peace River, CANADA","Peachland, BC, CANADA","Pemberton, CANADA","Pembroke, CANADA","Pender Island, CANADA","Penobsquis, NB, CANADA","Penticton, CANADA","Perce, CANADA","Perth, CANADA","Petawawa, CANADA","Peterborough, ON, CANADA","Petite-Riviere-Saint-Francois, QC, CANADA","Petit-Saguenay, QC, CANADA","Pickering, CANADA","Picton, CANADA","Pictou, CANADA","Piedmont, CANADA","Pincher Creek, CANADA","Piopolis, QC, CANADA","Pitt Meadows, CANADA","Plamondon, AB, CANADA","Plaster Rock, NB, CANADA","Pleasant Bay, NS, CANADA","Plessisville, QC, CANADA","Pocahontas, AB, CANADA","Pointe Claire, CANADA","Pointe Verte, NB, CANADA","Pointe-au-Pere, QC, CANADA","Pointe-au-Pic, QC, CANADA","Pointe-aux-Trembles, QC, CANADA","Pointe-du-Chene, NB, CANADA","Pomquet, NS, CANADA","Ponoka, CANADA","Port Alberni, CANADA","Port au Choix, NL, CANADA","Port Carling, CANADA","Port Colborne, ON, CANADA","Port Coquitlam, CANADA","Port Dufferin, NS, CANADA","Port Elgin, CANADA","Port Hardy, BC, CANADA","Port Hastings, CANADA","Port Hawkesbury, CANADA","Port Hope, CANADA","Port McNeill, BC, CANADA","Port Moody, BC, CANADA","Port Renfrew, BC, CANADA","Port Rexton, NL, CANADA","Port Severn, ON, CANADA","Port Stanley, ON, CANADA","Port Sydney, ON, CANADA","Portage La Prairie, CANADA","Port-au-Saumon, QC, CANADA","Port-Daniel, QC, CANADA","Porters Lake, NS, CANADA","Port-Menier, QC, CANADA","PORTNEUF, QC, CANADA","Powell River, CANADA","Prescott, ON, CANADA","Priddis, AB, CANADA","Prince Albert, CANADA","Prince George, CANADA","Prince Rupert, CANADA","Princeton, CANADA","Princeville, QC, CANADA","Prospect, NS, CANADA","Providence Bay, ON, CANADA","Provost, CANADA","Pubnico, NS, CANADA","Quadra Island, BC, CANADA","Qualicum Beach, BC, CANADA","Quathiaski Cove, CANADA","Québec, QC, CANADA","Quesnel, CANADA","Quispamsis, CANADA","Racine, QC, CANADA","Radisson, SK, CANADA","Radium Hot Springs, CANADA","Rawdon, QC, CANADA","Red Lake, ON, CANADA","Redcliff, AB, CANADA","Redwater, AB, CANADA","Regina, CANADA","Renfrew, ON, CANADA","Repentigny, QC, CANADA","Revelstoke, CANADA","Richmond, CANADA","Richmond Hill, ON, CANADA","Ridgetown, CANADA","Rigaud, CANADA","Rimbey, CANADA","Rimouski, CANADA","Riondel, BC, CANADA","Riske Creek, BC, CANADA","Riverside, NB, CANADA","Riviere du Loup, CANADA","Riviere-au-Dore, QC, CANADA","Riviere-Blanche, QC, CANADA","Riviere-la-Madeleine, QC, CANADA","Roberts Creek, BC, CANADA","Roberval, CANADA","Rockport, ON, CANADA","Rocky Harbour, NL, CANADA","Rocky Mountain House, CANADA","Rogers, BC, CANADA","Rosemere, QC, CANADA","Roseneath, ON, CANADA","Rosseau, ON, CANADA","Rossland, CANADA","Rothesay, NB, CANADA","Rouyn, QC, CANADA","Rustico, PE, CANADA","Saanichton, CANADA","Sackville, CANADA","Sacre-Coeur-Saguenay, QC, CANADA","SAGUENAY, QC, CANADA","Saint - Hyacinthe, QC, CANADA","Saint Adolphe D'Howard, QC, CANADA","Saint Aime Des Lacs, QC, CANADA","Saint Andre de Kamouraska, QC, CANADA","Saint Andrews, CANADA","Saint Anthony, CANADA","Saint Catharines, CANADA","Saint Come, QC, CANADA","Saint Elie, CANADA","Saint Ferreol les Neiges, QC, CANADA","Saint Hilarion, QC, CANADA","Saint Hippolyte, QC, CANADA","Saint Hyacinthe, CANADA","Saint Jacobs, ON, CANADA","Saint Jacques, NB, CANADA","Saint James, MB, CANADA","Saint Jean de Matha, QC, CANADA","Saint Jerome, QC, CANADA","Saint Johns, NB, CANADA","Saint John's, NL, CANADA","Saint Jovite, QC, CANADA","Saint Laurent, CANADA","Saint Leonard, NB, CANADA","Saint Martins, NB, CANADA","Saint Mathieu Du Parc, QC, CANADA","Saint Michel des Saints, QC, CANADA","Saint Paul, CANADA","Saint Paul, AB, CANADA","Saint Paulin, QC, CANADA","Saint Quentin, NB, CANADA","Saint Thomas, CANADA","SAINT URBAIN, CANADA","Saint Zenon, QC, CANADA","Saint-Alexis-des-Monts, QC, CANADA","Saint-Anaclet, QC, CANADA","Saint-Andre, QC, CANADA","Saint-Andre-Avellin, QC, CANADA","Saint-Antoine de Tilly, QC, CANADA","Saint-Antoine-Lotbiniere, QC, CANADA","Saint-Antonin, QC, CANADA","Saint-Augustin-de-Desmaures, QC, CANADA","Saint-Basile, CANADA","Saint-Basile-le-Grand, QC, CANADA","Saint-Bernard, QС, CANADA","Saint-Bernard-de-Lacolle, QC, CANADA","Saint-Bruno-de-Montarville, QC, CANADA","Saint-Charles-sur-Richelieu, QC, CANADA","Saint-Damien, QC, CANADA","Saint-David-de-Falardeau, QC, CANADA","Saint-Denis-sur-Richelieu, QC, CANADA","Saint-Donat-de-Montcalm, QC, CANADA","Sainte Agathe Des Monts, QC, CANADA","Sainte Anne des Lacs, QC, CANADA","Sainte Brigitte De Laval, QC, CANADA","Sainte Flore de Grand Mere, QC, CANADA","Sainte Foy, QC, CANADA","Sainte-Adele, QC, CANADA","Sainte-Anne, MB, CANADA","Sainte-Anne-de-Beaupre, QC, CANADA","Sainte-Anne-des-Monts, QC, CANADA","Sainte-Anne-du-Lac, QC, CANADA","Sainte-Catherine, QC, CANADA","Sainte-Catherine-de-la-Jacques-Cartier, CANADA","Sainte-Flavie, QC, CANADA","Sainte-Helene-de-Bagot, QC, CANADA","Sainte-Helene-de-Kamouraska, QC, CANADA","Sainte-Luce-sur-Mer, QC, CANADA","Sainte-Lucie-de-Doncaster, QC, CANADA","Sainte-Marguerite-Esterel, CANADA","Sainte-Marie, QC, CANADA","Sainte-Petronille, QC, CANADA","Sainte-Rose-du-Nord, CANADA","Saint-Eustache, QC, CANADA","Saint-Fabien, QC, CANADA","Saint-Faustin, CANADA","Saint-Felicien, QC, CANADA","Saint-Fulgence, QC, CANADA","Saint-Gabriel, QC, CANADA","Saint-Gabriel-de-Brandon, QC, CANADA","Saint-Gedeon, QC, CANADA","Saint-Georges, CANADA","Saint-Georges de Malbaie, CANADA","Saint-Henri-de-Taillon, QC, CANADA","Saint-Honore, QC, CANADA","Saint-Hubert, QC, CANADA","Saint-Hyacinthe, CANADA","Saint-Irenee, QC, CANADA","Saint-Jean, QC, CANADA","Saint-Jean-de-Boischatel, QC, CANADA","Saint-Jean-des Piles, QC, CANADA","Saint-Jean-Port-Joli, QC, CANADA","Saint-Jean-sur-Richelieu, QC, CANADA","Saint-Joseph-de-Beauce, QC, CANADA","Saint-Joseph-de-Ham-Sud, QC, CANADA","Saint-Joseph-de-la-Rive, QC, CANADA","Saint-Laurent-de-l'ile d'Orleans, QC, CANADA","Saint-Leon-de-Standon, QC, CANADA","Saint-Liboire, QC, CANADA","Saint-Mathieu-de-Beloeil, QC, CANADA","Saint-Maurice-de-l'Echouerie, QC, CANADA","Saint-Pascal, QC, CANADA","Saint-Paul-de-Montminy, QC, CANADA","Saint-Philemon, QC, CANADA","Saint-Raymond, QC, CANADA","Saint-Roch-des-Aulnaies, QC, CANADA","Saint-Sauveur-des-Monts, QC, CANADA","Saint-Simeon, QC, CANADA","Saint-Simon-de-Rimouski, QC, CANADA","Saint-Tite-des-Caps, QC, CANADA","Saint-Zotique, QC, CANADA","Salaberry-de-Valleyfield, QC, CANADA","Salmon Arm, CANADA","Salt Springs Island, CANADA","Sarnia, CANADA","Saskatoon, CANADA","Saturna Island, BC, CANADA","Sault Sainte Marie, ON, CANADA","SAVONA, CANADA","Sayward, BC, CANADA","Scanterbury, MB, CANADA","Scarborough, CANADA","Scotstown, QC, CANADA","SE ADELE, QC, CANADA","Sechelt, CANADA","Seebe, AB, CANADA","Selkirk, MB, CANADA","Sept-Iles, CANADA","Severn Bridge, ON, CANADA","Severn, ON, CANADA","Shaunavon, SK, CANADA","Shawinigan, CANADA","Shawnigan Lake, BC, CANADA","Shawville, QC, CANADA","Shediac, NB, CANADA","Shefford, QC, CANADA","Shelburne, NS, CANADA","Sherbrooke, CANADA","Sherwood Park, CANADA","Sherwood Park, AB, CANADA","Sicamous, CANADA","Silver Mountain, ON, CANADA","Silver Star, CANADA","Simcoe, ON, CANADA","Sioux Lookout, CANADA","Skookumchuck, BC, CANADA","Slave Lake, AB, CANADA","Smithers, CANADA","Smiths Cove, CANADA","Smiths Falls, CANADA","Sombra, ON, CANADA","Sooke, CANADA","Sorel, QC, CANADA","Sorrento, BC, CANADA","Souris, CANADA","South River, ON, CANADA","Southampton, ON, CANADA","Spaniards Bay, NF, CANADA","Spaniards Bay, NL, CANADA","Sparwood, BC, CANADA","Spillimacheen, BC, CANADA","Spruce Grove, AB, CANADA","Squamish, CANADA","Squilax, BC, CANADA","St Andre, NB, CANADA","St Catharines, CANADA","St Marc sur Richelieu, QC, CANADA","St Marys, ON, CANADA","St Saveur, BC, CANADA","St. Albert, AB, CANADA","St. Apollinaire, QC, CANADA","St. Catharines, CANADA","St. John's, Newfoundland and Labrador, CANADA","St. John's, NL, CANADA","St. Peters, NS, CANADA","St. Peter's, NS, CANADA","Stanhope, CANADA","Stanley Bridge, PE, CANADA","Ste Petronille, PQ, CANADA","Steinbach, CANADA","Stellarton, CANADA","Stephenville, CANADA","Stettler, CANADA","Stewiacke, NS, CANADA","St-Ferdinand, QC, CANADA","Stirling, ON, CANADA","Stoneham Québec, QC, CANADA","Stony Plain, CANADA","Stouffville, ON, CANADA","Stoughton, SK, CANADA","St-Pierre-de-l'Ile-d'Orleans, QC, CANADA","St-Raphael-de-Bellechasse, QC, CANADA","Stratford, ON, CANADA","Strathmore, CANADA","Sturdies Bay, BC, CANADA","Sturgeon Falls, CANADA","Sudbury, CANADA","Summerland, CANADA","Summerside, CANADA","Sun Peaks, CANADA","Sundre, AB, CANADA","Sunshine Village Banff Ski Resort, CANADA","Sunshine, AB, CANADA","Sunwapta Falls, AB, CANADA","Sunwapta, AB, CANADA","Surrey, CANADA","Sussex, CANADA","Sutton, QC, CANADA","Swan River, CANADA","Swift Current, CANADA","Sydney, CANADA","Sydney Forks, NS, CANADA","Sylvan Lake, CANADA","Taber, CANADA","Tadoussac, CANADA","Tagish, YT, CANADA","Tara, ON, CANADA","Tatamagouche, NS, CANADA","Tavistock, ON, CANADA","Telkwa, CANADA","Temiscouata-sur-le-Lac, QC, CANADA","Templeton, QC, CANADA","Terrace, CANADA","Terrebonne, CANADA","Tete Jaune, BC, CANADA","The Pas, CANADA","Thessalon, CANADA","Thetford Mines, CANADA","Thompson, CANADA","Thornbury, CANADA","Thornhill, CANADA","Thorold, CANADA","Thorsby, AB, CANADA","Three Hills, CANADA","Thunder Bay, CANADA","Tillsonburg, CANADA","Timmins, CANADA","Tisdale, SK, CANADA","Tobermory, CANADA","Tofino, CANADA","Toronto, ON, CANADA","Tors Cove, NL, CANADA","Tracadie, NB, CANADA","Trail, BC, CANADA","Trenton, CANADA","Trenton, ON, CANADA","Trinity, NL, CANADA","Trois Rives, QC, CANADA","Trois-Pistoles, QC, CANADA","Trois-Rivieres, QC, CANADA","Troy, NS, CANADA","Truro, CANADA","Tsawwassen, BC, CANADA","Tumbler Ridge, CANADA","Tweed, ON, CANADA","Twillingate Notredame, CANADA","Ucluelet, CANADA","Union Bay, BC, CANADA","Upper Laberge, YT, CANADA","Val-David, QC, CANADA","Val-des-Lacs, QC, CANADA","Val-d'Or, QC, CANADA","Valemount, CANADA","Vallee-Jonction, QC, CANADA","Valleyview, AB, CANADA","Val-Morin, QC, CANADA","Vananda, BC, CANADA","Vancouver, CANADA","Vanderhoof, BC, CANADA","Varennes, QC, CANADA","Vars, ON, CANADA","Vaudreil, CANADA","Vaudreuil-Dorion, QC, CANADA","Vaughan, CANADA","Vauxhall, AB, CANADA","Vavenby, BC, CANADA","Vegreville, AB, CANADA","Vermilion, CANADA","Vernon, CANADA","Victoria Beach, MB, CANADA","Victoria, BC, CANADA","Victoriaville, QC, CANADA","Viking, AB, CANADA","Village of Alton - Caledon, ON, CANADA","VILLE DU LAC DELAGE, QC, CANADA","Ville-Marie, QC, CANADA","Virden, MB, CANADA","Vulcan, AB, CANADA","Waasis, NB, CANADA","Wabamun, AB, CANADA","Wainwright, AB, CANADA","Wakefield, QC, CANADA","Walkerton, CANADA","Wallace, NS, CANADA","Wallaceburg, ON, CANADA","Wasaga Beach, ON, CANADA","Wasagaming, MB, CANADA","Waskesiu Lake, CANADA","Waterloo, CANADA","Waterloo, ON, CANADA","Waterton, CANADA","Waterton Lakes National Park, AB, CANADA","Watrous, SK, CANADA","Wawa, ON, CANADA","Weedon-Centre, QC, CANADA","Welland, CANADA","Wellington, ON, CANADA","Wendake, QC, CANADA","Wentworth-Nord, QC, CANADA","West Bay, CANADA","WEST BROME, CANADA","West Edmonton, CANADA","West Kelowna, CANADA","West Vancouver, BC, CANADA","Westbank, CANADA","Western Shore, CANADA","Westlock, CANADA","Westport, ON, CANADA","Wetaskiwin, CANADA","Weyburn, CANADA","Whaletown, BC, CANADA","Wheatley, ON, CANADA","Whistler, BC, CANADA","Whitby, CANADA","White Rock, CANADA","Whitecourt, CANADA","Whitehorse, YT, CANADA","Whiteway, NL, CANADA","Whitney, CANADA","Wiarton, ON, CANADA","Williams Lake, CANADA","Windermere, BC, CANADA","Windermere, ON, CANADA","Windsor, CANADA","WINDSOR - CANADA, CANADA","Windsor, Nova Scotia, CANADA","Windsor, Ontario, CANADA","Winfield, CANADA","Winkler, CANADA","Winnipeg, CANADA","Witless Bay, NL, CANADA","Wolfville, CANADA","Woodbridge, CANADA","Woodstock, CANADA","Woodstock, NB, CANADA","Woodstock, ON, CANADA","Woodview, CANADA","Yarmouth, NS, CANADA","Yellowknife, CANADA","Yoho National Park, CANADA","York, CANADA","Yorkton, CANADA","Youngstown, AB, CANADA","Zeballos, BC, CANADA",
    ];
    $( "#PropertyAddressCity" ).autocomplete({
    source: function(req, responseFn) {
        var re = $.ui.autocomplete.escapeRegex(req.term);
        var matcher = new RegExp( "^" + re, "i" );
        var a = $.grep( availableTags, function(item,index){
            return matcher.test(item);
        });
        responseFn( a );
    }
    });
    });
    $( "#PropertyAddressCityDes" ).autocomplete({
    source: function(req, responseFn) {
        var re = $.ui.autocomplete.escapeRegex(req.term);
        var matcher = new RegExp( "^" + re, "i" );
        var a = $.grep( availableTags, function(item,index){
            return matcher.test(item);
        });
        responseFn( a );
    }
    });
       $(document).ready(function() {
    //On Click Event
    $("ul.nav-tabs li").click(function() {
    
        $('a[href="#property-map"]').on('shown.bs.tab', function(e)
    {
        google.maps.event.trigger(mapdepart, 'resize');
         google.maps.event.trigger(maparrive, 'resize');
    });
    });

});
</script>
     
