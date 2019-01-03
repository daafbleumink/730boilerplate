<?php get_header() ?>

    <style>
    #scrolldown p {font-size: 16px;line-height:23px;}
    #scrolldown h2 {font-size:24px;font-weight:900;padding-top:2rem;padding-bottom:1rem}
    #scrolldown h3 {padding-top:1rem;padding-bottom:0.5rem}
    #scrolldown img {padding-top:30px}
    #scrolldown a {color:#181f41;}
    #scrolldown a:hover {text-decoration:none;}
    </style>

        <header class="mb-12">
			<div class="h-screen w-screen flex bg-cover bg-right sm:bg-contain bg-no-repeat" style="background-image: url(<?php echo get_template_directory_uri() . '/dist/img/blue-trans.png'?>), url(<?php echo get_template_directory_uri() . '/dist/img/blue-trans.png'?>), url(<?php the_post_thumbnail_url( ); ?>)">
				<div class="md:w-1/3 flex bg-white">
					<h1 id="project" class="absolute w-full sm:w-2/5 ml-4 sm:ml-32 text-42 sm:text-56 leading-tight inline-block self-center font-black">
						<?php the_title(); ?>
					</h1>
				</div>
				<div class="w-16 h-16 flex md:w-2/3">
					<div class="md:h-screen">
						<a href="#scrolldown" class="absolute mb-16 sm:mb-20 pin-r pin-b rotate-90 transform-origin-b no-underline text-blue-dark hover:text-blue-light">Scroll down &rarr;</a>
					</div>
				</div>
			</div>
		</header>
        
        <section id="scrolldown" class="container p-4 w-full md:p-0 sm:w-full md:w-1/2 xl:w-1/3 mx-auto mb-12">
            <div class="mb-10">
                <?php the_content() ?>
            </div>
            <span><a class="no-underline slide-to-left ml-4" href="<?php echo site_url() ?>"><span class="arrow">&larr;</span> Terug naar home</a></span>
        </section>

<?php get_footer() ?>
