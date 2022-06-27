<?php
/**
 * The template for displaying archive
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package Design_Comuni_Italia
 */

global $obj, $the_query, $load_posts;

$max_posts = isset($_GET['max_posts']) ? $_GET['max_posts'] : 10;
$load_posts = 10;
$args = array(
    's' => $_GET['search'],
    'posts_per_page' => $max_posts,
    'post_type'      => 'servizio',
    'categorie_servizio' => $obj->name,
    'orderby'        => 'post_title',
    'order'          => 'ASC'
);
$the_query = new WP_Query( $args );
$servizi = $the_query->posts;

$amministrazione = dci_get_related_unita_amministrative();
$bandi = dci_get_related_bandi();

get_header();
?>
 <main>
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-12 col-lg-10">
            <?php get_template_part("template-parts/common/breadcrumb"); ?>
          <div class="cmp-hero">
            <section class="it-hero-wrapper bg-white align-items-start">
              <div class="it-hero-text-wrapper pt-0 ps-0 pb-4 pb-lg-60">
                <h1 class="text-black title-xxxlarge mb-2">
                  <?php 
                    if($obj) echo $obj->name; 
                    else echo "Tutti i servizi";
                  ?>
                </h1>
                <p class="text-black titillium text-paragraph">
                    <?php echo $obj->description; ?>
                </p>
              </div>
            </section>
          </div>
        </div>
      </div>
    </div>
  
    <div class="bg-grey-card">
      <form role="search" id="search-form" method="get" class="search-form">
          <button type="submit" class="d-none"></button>
          <div class="container">
            <div class="row ">
              <h2 class="visually-hidden">Esplora tutti i servizi</h2>
              <div class="col-12 col-lg-8 pt-30 pt-lg-50 pb-lg-50">
                <div class="cmp-input-search">
                  <div class="form-group autocomplete-wrapper mb-0">
                  <label for="autocomplete-two" class="visually-hidden">Cerca una parola chiave</label>
                  <input type="search" 
                    class="autocomplete" 
                    placeholder="Cerca una parola chiave"
                    id="autocomplete-two"
                    name="search"
                    value="<?php echo $_GET['search']; ?>"
                    data-bs-autocomplete="[]">
                  <span class="autocomplete-icon" aria-hidden="true">
                    <svg class="icon icon-sm icon-primary" role="img" aria-labelledby="autocomplete-label"><use href="#it-search"></use></svg>
                  </span>
                
                      <p id="autocomplete-label" class="mt-2 mt-lg-3 mb-4"><strong><?php echo $the_query->found_posts; ?> </strong>servizi trovati in ordine alfabetico</p>
                  </div>
                </div>
                <?php foreach ($servizi as $servizio) { 
                  $description = dci_get_meta('descrizione_breve', '_dci_servizio_', $servizio->ID);  
                ?>
                <div class="cmp-card-latest-messages mb-3 mb-30" data-bs-toggle="modal" data-bs-target="#" id="">
                  <div class="card drop-shadow px-4 pt-4 pb-4 rounded">
                    <div class="card-header border-0 p-0">
                    </div>
                    <div class="card-body p-0 my-2">
                      <h3 class="green-title-big t-primary mb-8"><a href="<?php echo get_permalink($servizio->ID); ?>" title="Vai alla pagina <?php echo $servizio->post_title; ?> " aria-label="Vai alla pagina <?php echo $servizio->post_title; ?> "><?php echo $servizio->post_title; ?> </a></h3>
                      <p class="text-paragraph "><?php echo $description; ?></p>
                    </div>
                  </div>
                </div>
                <?php } ?>
                <?php get_template_part("template-parts/search/more-results"); ?>
              </div>
              
              <?php if ( is_array($amministrazione) && count($amministrazione) ) { ?>
                <div class="col-12 col-lg-4 pt-50 pb-30 pt-lg-5 ps-lg-5">
                  <div class="link-list-wrap">
                    <div class="title-xsmall-semi-bold"><span>UFFICI</span></div>
                    <ul class="link-list t-primary">
                      <?php foreach ($amministrazione as $item) { ?>
                        <li class="mb-3 mt-3">
                          <a class="list-item ps-0 title-medium underline" href="<?php echo $item['link']; ?>" aria-label="Vai alla sezione <?php echo $item['title']; ?>" title="Vai alla sezione <?php echo $item['title']; ?>">
                            <span><?php echo $item['title']; ?></span>
                          </a>
                        </li>
                      <?php } ?>                      
                      <li>
                        <a class="list-item ps-0 text-button-xs-bold d-flex align-items-center" href="<?php echo get_permalink( get_page_by_path( 'amministrazione' ) ); ?>" aria-label="Vai all'area amministrativa" title="Vai all'area amministrativa">
                          <span class="mr-10">VAI ALL’AREA AMMINISTRATIVA</span>
                          <svg class="icon icon-xs icon-primary">
                            <use href="#it-arrow-right"></use>
                          </svg>
                        </a>
                      </li>
                    </ul>
                  </div>
                </div>
              <?php } ?>
            </div>
          </div>
      </form>
    </div>
                        
    <?php if ( is_array($bandi) && count($bandi) ) { ?>
      <div class="container">
        <h2 class="title-xxlarge mt-40 mb-40 mt-lg-60 mb-lg-40">Bandi</h2>
        <div class="row flex-wrap justify-content-between gy-4 gy-lg-5 gx-lg-5 pb-3 pb-lg-60 align-items-stretch">
          <div class="col-12 col-lg-4">
            <?php foreach ($bandi as $item) { ?>
              <div class="cmp-card-simple card-wrapper pb-0">
                <div class="card shadow rounded">
                  <div class="card-body">
                    <a href="<?php echo $item['link']; ?>" aria-label="Vai all'argomento <?php echo $item['titolo']; ?>" title="Vai all'argomento <?php echo $item['titolo']; ?>">
                      <h3 class="card-title t-primary title-xlarge">
                        <?php echo $item['titolo']; ?>
                      </h3>
                    </a>
                    <p class="titillium text-paragraph "><?php echo $item['description']; ?></p>
                  </div>
                </div>
              </div>
            <?php }?>
          </div>
        </div>
      </div>  
    <?php } ?>
    
    <?php echo get_template_part( 'template-parts/common/valuta-servizio'); ?>
    <?php echo get_template_part( 'template-parts/common/assistenza-contatti'); ?>
  </main>
<?php
get_footer();