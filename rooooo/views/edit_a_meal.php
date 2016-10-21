<?
    echo link_tag(base_url().'css/walk.css');
    echo link_tag(base_url().'css/jquery.datepick.css');
    echo '<script src="' . base_url() . 'js/edit.js"></script>';
    echo '<script src="' . base_url() . 'js/jquery.plugin.js"></script>';
    echo '<script src="' . base_url() . 'js/jquery.datepick.min.js"></script>';
    $form_attribs = array(
        'class' => 'form-inline',
        'id' => 'log_form',
    );
    echo form_open('',$form_attribs);
    echo '<div class="row-fluid">';
    echo $dogs;
    echo '</div>';
?>

<div id="doggie_data" class="container">
    <div class="row">
        <h3><span class="dogName"></span>'s Meals</h3>
    </div>
</div>
<div id="meal_list_container" class="text-center">
</div>