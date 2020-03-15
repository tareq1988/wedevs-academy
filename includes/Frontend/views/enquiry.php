<div class="wedevs-enquiry-form" id="wedevs-enquiry-form">

    <form action="" method="post">

        <div class="form-row">
            <label for="name"><?php _e( 'Name', 'wedevs-academy' ); ?></label>

            <input type="text" id="name" name="name" value="" required>
        </div>

        <div class="form-row">
            <label for="email"><?php _e( 'E-Mail', 'wedevs-academy' ); ?></label>

            <input type="email" id="email" name="email" value="" required>
        </div>

        <div class="form-row">
            <label for="message"><?php _e( 'Message', 'wedevs-academy' ); ?></label>

            <textarea name="message" id="message" required></textarea>
        </div>

        <div class="form-row">

            <?php wp_nonce_field( 'wd-ac-enquiry-form' ); ?>

            <input type="hidden" name="action" value="wd_academy_enquiry">
            <input type="submit" name="send_enquiry" value="<?php esc_attr_e( 'Send Enquiry', 'wedevs-academy' ); ?>">
        </div>

    </form>
</div>
