<div id='property-address' class="tab-pane">
               <?php
               $array_country = array('Afghanistan','Afrique du Sud','Afrique Centrale','Albanie','Algerie','Allemagne','Andorre','Angola','Anguilla','Arabie Saoudite','Argentine','Armenie','Australie','Autriche','Azerbaidjan','Bahamas','Bangladesh','Barbade','Bahrein','Belgique','Belize','Benin','Bermudes','Bielorussie','Bolivie','Botswana','Bhoutan','Boznie Herzegovine','Bresil','Brunei','Bulgarie','Burkina Faso','Burundi','Caiman','Cambodge','Cameroun','Canada','Canaries','Cap Vert','Chili','Chine','Chypre','Colombie','Colombie','Congo','Congo democratique','Cook','Coree du Nord','Coree du Sud','Costa Rica','Côte d Ivoire','Croatie','Cuba','Danemark','Djibouti','Dominique','Egypte','Emirats Arabes Unis','Equateur','Erythree','Espagne','Estonie','Etats Unis','Ethiopie','Falkland','Feroe','Fidji','Finlande','France','Gabon','Gambie','Georgie','Ghana','Gibraltar','Grece','Grenade','Groenland','Guadeloupe','Guam','Guatemala','Guernesey','Guinee','Guinee Bissau','Guinee Equatoriale','Guyana','Guyane Francaise','Haiti','Hawaii','Honduras','Hong Kong','Hongrie','Inde','Indonesie','Iran','Iraq','Irlande','Islande','Israel','italie','Jamaique','Jan Mayen','Japon','Jersey','Jordanie','Kazakhstan','Kenya','Kirghizistan','Kiribati','Koweit','Laos','Lesotho','Lettonie','Liban','Liberia','Liechtenstein','Lituanie','Luxembourg','Lybie','Macao','Macedoine','Madagascar','Madère','Malaisie','Malawi','Maldives','Mali','Malte','Man','Mariannes du Nord','Maroc','Marshall','Martinique','Maurice','Mauritanie','Mayotte','Mexique','Micronesie','Midway','Moldavie','Monaco','Mongolie','Montserrat','Mozambique','Namibie','Nauru','Nepal','Nicaragua','Niger','Nigeria','Niue','Norfolk','Norvege','Nouvelle Caledonie','Nouvelle Zelande','Oman','Ouganda','Ouzbekistan','Pakistan','Palau','Palestine','Panama','Papouasie Nouvelle Guinee','Paraguay','Pays Bas','Perou','Philippines','Pologne','Polynesie','Porto Rico','Portugal','Qatar','Republique Dominicaine','Republique Tcheque','Reunion','Roumanie','Royaume Uni','Russie','Rwanda','Sahara Occidental','Sainte Lucie','Saint Marin','Salomon','Salvador','Samoa Occidentales','Samoa Americaine','Sao Tome et Principe','Senegal','Seychelles','Sierra Leone','Singapour','Slovaquie','Slovenie','Somalie','Soudan','Sri Lanka','Suede','Suisse','Surinam','Swaziland','Syrie','Tadjikistan','Taiwan','Tonga','Tanzanie','Tchad','Thailande','Tibet','Timor Oriental','Togo','Trinite et Tobago','Tristan de cuncha','Tunisie','Turmenistan','Turquie','Ukraine','Uruguay','Vanuatu','Vatican','Venezuela','Vierges Americaines','Vierges Britanniques','Vietnam','Wake','Wallis et Futuma','Yemen','Yougoslavie','Zambie','Zimbabwe');
               $array_country = array_combine($array_country, $array_country);
                echo '<div class="span6">';
                echo '<table class="table table-striped" style="width:100%;">';
                echo '<thead><tr><td><strong>Adress départ :</strong></td></tr></thead><tbody><tr><td>';
                echo $this->Form->input('PropertyAddress.0.line_address', array(
                    'label' => 'Adresse',
                )).'</td></tr><tr><td>';
                echo $this->Form->input('PropertyAddress.0.country', array(
                    'label' => 'Pays',
                    'options' => $array_country,
                )).'</td></tr><tr><td>';
                echo $this->Form->input('PropertyAddress.0.province', array(
                    'label' => 'Province',
                )).'</td></tr><tr><td>';
                 echo $this->Form->input('PropertyAddress.0.city', array(
                    'label' => 'Ville',
                )).'</td></tr></tbody></table></div>';
                 echo $this->Form->hidden('PropertyAddress.0.isdepart', array(
                    'value' => 1,
                ));
               
                echo '<div class="span6">';
                echo '<table class="table table-striped" style="width:100%;">';
                echo '<thead><tr><td><strong>Adress arrivé :</strong></td></tr></thead><tbody><tr><td>';
                echo $this->Form->input('PropertyAddress.1.line_address', array(
                    'label' => 'Adresse',
                )).'</td></tr><tr><td>';
                echo $this->Form->input('PropertyAddress.1.country', array(
                    'label' => 'Pays',
                    'options' => $array_country,
                )).'</td></tr><tr><td>';
                echo $this->Form->input('PropertyAddress.1.province', array(
                    'label' => 'Province',
                )).'</td></tr><tr><td>';
                 echo $this->Form->input('PropertyAddress.1.city', array(
                    'label' => 'Ville',
                )).'</td></tr></tbody></table></div>';
                  echo $this->Form->hidden('PropertyAddress.1.isdepart', array(
                    'value' => 0,
                ));
               
                  ?>
            </div>