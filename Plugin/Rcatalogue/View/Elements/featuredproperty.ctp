<?php 
    
    if(isset($featured))
    {
        echo $this->Property->renderFeaturedProperty($featured);
    }
    else
    {
        echo $this->Property->renderFeaturedProperty();
    }
?>