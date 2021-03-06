<?php
/*
Template Name: Workers
*/

// Get teams and members connected to current user
$dt_user_team_members_list = dt_get_user_team_members_list( get_current_user_id() );

?>

<?php get_header(); ?>

<?php
dt_print_breadcrumbs(
    [
        [ home_url( '/' ), __( "Dashboard" ) ],
        [ home_url( '/' ) . "workers", __( "Workers" ) ],
    ],
    get_the_title(),
    false
); ?>

<div id="content">

    <div id="inner-content" class="grid-x grid-margin-x align-center">

        <div class="medium-8 small-12 cell ">

            <?php
            if ( $dt_user_team_members_list ) {

                foreach ( $dt_user_team_members_list as $team_list ) { ?>

                    <div class="bordered-box">

                        <span class="section-header"><?php esc_html_e( $team_list['team_name'], 'disciple_tools' )?></span>

                        <hr size="1" style="max-width:100%"/>

                        <div class="grid-container fluid">

                            <?php if ( !empty( $team_list['team_members'] ) ) { ?>

                                <div class="grid-x grid-margin-x">

                                    <?php foreach ( $team_list['team_members'] as $member ) {
                                        // reset variables
                                        $dt_user = '';
                                        $dt_user_meta = [];
                                        $dt_user_fields = [];
                                        $dt_locations = [];

                                        // get member data
                                        $dt_user = get_user_by( 'id', $member['ID'] ); // Returns WP_User object
                                        $dt_user_meta = get_user_meta( $member['ID'] ); // Full array of user meta data
                                        $dt_user_fields = dt_build_user_fields_display( $dt_user_meta ); // Compares the site settings in the config area with the fields available in the user meta table.
                                        $dt_locations = dt_get_user_locations_list( $member['ID'] ); // returns an array of locations for the member
                                        ?>

                                        <div class="cell small-3">

                                            <!-- Card -->
                                            <div class="card" data-open="reveal-<?php esc_html_e( $member['ID'], 'disciple_tools' )?>">

                                                <div class="card-image">

                                                    <?php echo get_avatar( $member['ID'], '250' ); ?>

                                                </div>
                                                <div class="card-section center">

                                                    <a data-open="reveal-<?php echo esc_attr( $member['ID'], 'disciple_tools' ); ?>">
                                                        <?php if ( !empty( $dt_user->first_name ) ) {
                                                            echo esc_html( $dt_user->first_name, 'disciple_tools' ) . ' ' . esc_html( $dt_user->last_name, 'disciple_tools' );
} else {
    esc_html_e( $dt_user->display_name, 'disciple_tools' );
} ?>
                                                    </a><br>

                                                    <?php ( isset( $dt_user_meta['dt_avalability'] ) && $dt_user_meta['dt_avalability'] == false ) ? print '<strong>' . esc_html( 'Not Available', 'disciple_tools' ) . '</strong>' : print esc_html( 'Available', 'disciple_tools' );  ?>

                                                </div>

                                            </div>

                                            <!-- Reveal -->
                                            <div class="reveal" id="reveal-<?php esc_html_e( $member['ID'], 'disciple_tools' ); ?>" data-reveal>

                                                <h1>
                                                <?php
                                                if ( !empty( $dt_user->first_name ) ) {
                                                    echo esc_html( $dt_user->first_name, 'disciple_tools' ) . ' ' . esc_html( $dt_user->last_name, 'disciple_tools' );
                                                } else {
                                                    esc_html_e( $dt_user->display_name, 'disciple_tools' );
                                                }
                                                ?>
                                                </h1>

                                                <p><?php echo get_avatar( $member['ID'], '150' ); ?></p>
                                                <p><?php ( isset( $dt_user_meta['dt_avalability'] ) && $dt_user_meta['dt_avalability'] == false ) ? print '<strong>' . esc_html( 'Not Available', 'disciple_tools' ) . '</strong' : print esc_html( 'Available', 'disciple_tools' );  ?></p>

                                                <p>
                                                    <strong><?php esc_html_e( 'Username', 'disciple_tools' )?></strong><br>
                                                    <?php esc_html_e( $dt_user->user_login, 'disciple_tools' )?>
                                                </p>

                                                <p>
                                                    <strong><?php esc_html_e( 'Nickname', 'disciple_tools' )?></strong><br>
                                                    <?php esc_html_e( $dt_user->nickname, 'disciple_tools' )?>
                                                </p>

                                                <p><strong><?php esc_html_e( 'Email', 'disciple_tools' )?></strong></p>
                                                <ul>
                                                    <?php
                                                    echo '<li><a href="mailto:' . esc_attr( $dt_user->user_email, 'disciple_tools' ) . '">' . esc_html( $dt_user->user_email, 'disciple_tools' ) . '</a> (System Email)</li>';
                                                    foreach ( $dt_user_fields as $field ) {
                                                        if ( $field['type'] == 'email' && !empty( $field['value'] ) ) {
                                                            echo '<li><a href="mailto:' . esc_html( $field['value'], 'disciple_tools' ) . '" target="_blank">' . esc_html( $field['value'], 'disciple_tools' ) . '</a> (' . esc_html( $field['label'], 'disciple_tools' ) . ')</li>';
                                                        }
                                                    }
                                                    ?>
                                                </ul>

                                                <strong><?php esc_html_e( 'Phone', 'disciple_tools' )?></strong>
                                                <ul>
                                                    <?php
                                                    foreach ( $dt_user_fields as $field ) {
                                                        if ( $field['type'] == 'phone' && !empty( $field['value'] ) ) {
                                                            echo '<li>' . esc_html( $field['value'], 'disciple_tools' ) . ' (' . esc_html( $field['label'], 'disciple_tools' ) . ')</li>';
                                                        }
                                                    }
                                                    ?>
                                                </ul>

                                                <strong><?php esc_html_e( 'Address', 'disciple_tools' )?></strong>
                                                <ul>
                                                    <?php
                                                    foreach ( $dt_user_fields as $field ) {
                                                        if ( $field['type'] == 'address' && !empty( $field['value'] ) ) {
                                                            echo '<li>' . esc_html( $field['value'], 'disciple_tools' ) . ' (' . esc_html( $field['label'], 'disciple_tools' ) . ')</li>';
                                                        }
                                                    }
                                                    ?>
                                                </ul>

                                                <strong><?php esc_html_e( 'Social', 'disciple_tools' )?></strong>
                                                <ul>
                                                    <?php
                                                    foreach ( $dt_user_fields as $field ) {
                                                        if ( $field['type'] == 'social' && !empty( $field['value'] ) ) {
                                                            echo '<li>' . esc_html( $field['value'], 'disciple_tools' ) . ' (' . esc_html( $field['label'], 'disciple_tools' ) . ')</li>';
                                                        }
                                                    }
                                                    ?>
                                                </ul>

                                                <strong><?php esc_html_e( 'Other', 'disciple_tools' )?></strong>
                                                <ul>
                                                    <?php
                                                    foreach ( $dt_user_fields as $field ) {
                                                        if ( $field['type'] == 'other' && !empty( $field['value'] ) ) {
                                                            echo '<li>' . esc_html( $field['value'], 'disciple_tools' ) . ' (' . esc_html( $field['label'], 'disciple_tools' ) . ')</li>';
                                                        }
                                                    }
                                                    ?>
                                                </ul>

                                                <strong><?php esc_html_e( 'Locations', 'disciple_tools' )?></strong>
                                                <ul>
                                                    <?php foreach ( $dt_locations as $location ) {
                                                        echo '<li>' .  esc_html( $location->post_title, 'disciple_tools' ) . '</li>';
} ?>
                                                </ul>

                                                <strong><?php esc_html_e( 'Biography', 'disciple_tools' )?></strong>
                                                <p><?php esc_html_e( $dt_user->user_description, 'disciple_tools' ); ?></p>

                                                <button class="close-button" data-close aria-label="Close modal"
                                                        type="button">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>

                                        </div>

                                    <?php } // end member foreach loop ?>

                                </div>

                            <?php } else { // end if members exist ?>

                                <div class="grid-x grid-margin-x grid-margin-y align-center-middle">
                                
                                    <?php esc_html_e( 'Have no other team members on this team', 'disciple_tools' )?>.
                                    
                                </div>


                            <?php } // end else members ?>

                        </div>

                    </div>

                <?php } // end team loop ?>

            <?php } else { // end if current user is member of any teams ?>

                <div class="bordered-box center">

                    <div class="grid-x grid-margin-x grid-margin-y align-center-middle">

                        <?php esc_html_e( 'You are not part of any teams', 'disciple_tools' )?>.

                    </div>

                </div>

            <?php } // end else ?>

        </div>

    </div> <!-- end #inner-content -->

</div> <!-- end #content -->


<?php get_footer(); ?>
