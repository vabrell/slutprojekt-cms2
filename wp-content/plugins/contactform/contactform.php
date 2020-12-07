<?php

/**
 * Plugin Name: Contact Form
 * Author: David Kjellson
 * Version: 1.0
 * Description: Add contact information
 **/

require 'acf-template.php';

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
                <div class="col-sm-10">
                  <?php while (have_rows('radioknappar')) {
                    the_row(); ?>
                    <div class="form-check form-check-inline">
                      <input class="form-check-input" type="radio" name="errand" id="contact" value="contact">
                      <label class="form-check-label" for="contact">
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
              <label for="name" class="col-sm-2 col-form-label"><?php the_sub_field('etikett'); ?></label>
              <div class="col-sm-10">
                <input type="text" class="form-control" id="name" placeholder="<?php the_sub_field('etikett'); ?>">
              </div>
            </div>
          <?php } ?>
          <!-- <div class="form-group row">
          <label for="email" class="col-sm-2 col-form-label">E-post</label>
          <div class="col-sm-10">
            <input type="email" class="form-control" id="email" placeholder="E-post">
          </div>
        </div> -->
          <?php
          if (get_row_layout() === 'textarea') { ?>
            <div class="form-group row">
              <label for="message" class="col-sm-2 col-form-label"><?php the_sub_field('etikett'); ?></label>
              <div class="col-sm-10">
                <textarea class="form-control" id="message" placeholder="<?php the_sub_field('etikett'); ?>" rows="3"></textarea>
              </div>
            </div>
          <?php }
          if (get_row_layout() === 'knapp') { ?>
            <div class="text-center">
              <button class="btn btn-outline-success my-2 my-sm-0" type="submit"><?php the_sub_field('etikett'); ?></button>
            </div>
            <input type="hidden" value="cms2_contactform">
        <?php }
        } ?>
      </form>
<?php
    }
    $contactcode = ob_get_clean();
    return $contactcode;
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
    // Skriv [contactform] som kortkod för att infoga.
    add_shortcode('contactform', [$this, 'contactform']);
  }
}

$contact = new Contactform(); ?>