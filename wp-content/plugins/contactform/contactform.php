<?php

/**
 * Plugin Name: Contact Form
 * Author: David Kjellson
 * Version: 1.0
 * Description: Add contact information
 **/

// require 'acf-template.php';

class Contactform
{
  function contactform()
  {
    ob_start();
    if (have_rows('kontaktformular', 'options')) {
?>
      <form action="<?php echo admin_url('admin-ajax.php'); ?>">
        <?php while (have_rows('kontaktformular', 'options')) {
          the_row();
          if (get_row_layout() === 'radioknappar') { ?>
            <fieldset class="form-group">
              <div class="row">
                <legend class="col-form-label col-sm-2 pt-0"><?php the_sub_field('etikett'); ?></legend>
                <?php $variabel = get_sub_field('datahandtag'); ?>
                <div class="col-sm-10">
                  <?php while (have_rows('radioknappar')) {
                    the_row(); ?>
                    <div class="form-check form-check-inline">
                      <input class="form-check-input" type="radio" name="<?php echo $variabel; ?>" value="<?php the_sub_field('knappetikett') ?>">
                      <label class="form-check-label" for="<?php the_sub_field('knappetikett') ?>">
                        <?php the_sub_field('knappetikett') ?>
                      </label>
                    </div>
                  <?php } ?>
                </div>
              </div>
            </fieldset>
          <?php }
          if (get_row_layout() === 'textfalt') { ?>
            <div class="form-group row">
              <label for="<?php the_sub_field('etikett'); ?>" class="col-sm-2 col-form-label"><?php the_sub_field('etikett'); ?></label>
              <div class="col-sm-10">
                <input type="text" class="form-control" name="<?php the_sub_field('datahandtag'); ?>" placeholder="<?php the_sub_field('etikett'); ?>">
              </div>
            </div>
          <?php }
          if (get_row_layout() === 'textarea') { ?>
            <div class="form-group row">
              <label for="<?php the_sub_field('etikett'); ?>" class="col-sm-2 col-form-label"><?php the_sub_field('etikett'); ?></label>
              <div class="col-sm-10">
                <textarea class="form-control" name="<?php the_sub_field('datahandtag'); ?>" placeholder="<?php the_sub_field('etikett'); ?>" rows="3"></textarea>
              </div>
            </div>
          <?php }
          if (get_row_layout() === 'knapp') { ?>
            <div class="text-center">
              <button class="btn btn-outline-success my-2 my-sm-0" type="submit"><?php the_sub_field('etikett'); ?></button>
            </div>
        <?php }
        } ?>
        <input type="hidden" value="cms2_contactform" name="action">
      </form>
<?php
      if (isset($_REQUEST['sent'])) {
        echo 'Tack för ditt meddelande!';
      }
    }
    $contactcode = ob_get_clean();
    return $contactcode;
  }

  function insertpost()
  {
    $post_id = wp_insert_post(
      [
        'post_title' => $_REQUEST['cms2_name'],
        'post_content' => $_REQUEST['cms2_message'],
        'post_type' => 'arenden'
      ]
    );
    update_post_meta($post_id, 'e-post', $_REQUEST['cms2_email']);
    update_post_meta($post_id, 'radioknapp', $_REQUEST['cms2_radio']);
    die();
  }

  function options()
  {
    acf_add_options_page([
      'page_title' => 'Kontaktformulär',
      'menu_title' => 'Kontaktformulär',
      'menu_slug' => 'kontaktformular'
    ]);
  }

  function messages()
  {
    register_post_type('arenden', [
      'labels' => [
        'name' => 'Ärenden',
        'singular_name' => 'Ärende'
      ],
      'public' => true,
      'has_archive' => true
    ]);
  }

  public function __construct()
  {
    add_action('init', [$this, 'options']);
    add_action('init', [$this, 'messages']);
    add_action('wp_ajax_cms2_contactform', [$this, 'insertpost']);
    // Skriv [contactform] som kortkod för att infoga.
    add_shortcode('contactform', [$this, 'contactform']);
  }
}

$contact = new Contactform(); ?>