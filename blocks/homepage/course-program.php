<!--   COURSE CONTENT PROGRAM   -->
<?php if ( have_rows('course_program_repeater') ) : ?>
    <div class="courseProgram" id="course-program">
        <div class="courseProgram__wrapper">
            <h2><?php the_field('course_program_title'); ?></h2>
            <div class="courseProgram__items">
                <?php
                $i = 0;
                while ( have_rows('course_program_repeater') ) : the_row();
                ?>
                    <div class="courseProgram__tab">
                        <input type="checkbox" id="faq-<?php echo $i; ?>" />
                        <label for="faq-<?php echo $i; ?>">
                            <div class="courseProgram__icon"></div>
                            <p><?php the_sub_field('header'); ?></p>
                        </label>
                        <div class="courseProgram__answer">
                            <p><?php the_sub_field('body'); ?></p>
                        </div>
                    </div>
                    <?php $i += 1; ?>
                <?php endwhile; ?>
            </div>
        </div>
    </div>
<?php endif; ?>