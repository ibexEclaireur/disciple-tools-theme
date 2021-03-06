<?php

(function() {
?>
<?php
// Adjust the amount of rows in the grid

$grid_columns = 4; ?>

<?php if ( 0 === ( $wp_query->current_post  ) % $grid_columns ): ?>

    <div class="row archive-grid" data-equalizer> <!--Begin Row:-->

<?php endif; ?>

        <!--Item: -->
        <div class="large-3 medium-3 columns panel" data-equalizer-watch>

            <article id="post-<?php the_ID(); ?>" <?php post_class( '' ); ?> role="article">

                <header class="article-header">
                    <h3 class="title"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php the_title_attribute(); ?></a></h3>

                </header> <!-- end article header -->

                <section class="featured-image" itemprop="articleBody">
                    <?php the_post_thumbnail( 'full' ); ?>
                </section> <!-- end article section -->

                <section class="entry-content" itemprop="articleBody">
                    <?php the_content( '<button class="tiny">' . __( 'Read more...', 'disciple_tools' ) . '</button>' ); ?>
                </section> <!-- end article section -->

                <footer class="article-footer">
                    <?php get_template_part( 'parts/content', 'pray' ); ?>
                </footer>

            </article> <!-- end article -->

        </div>

<?php if ( 0 === ( $wp_query->current_post + 1 ) % $grid_columns || ( $wp_query->current_post + 1 ) === $wp_query->post_count ): ?>

   </div>  <!--End Row: -->

<?php endif; ?>

<?php
})();
