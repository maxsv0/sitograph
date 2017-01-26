{include file="$themePath/widget/header.tpl"}


<div class="container">

      <div class="blog-header">
        <h1 class="blog-title">The Bootstrap Blog</h1>
        <p class="lead blog-description">The official example template of creating a blog with Bootstrap.</p>
      </div>

      <div class="row">

        <div class="col-sm-8 blog-main">

{if $document}
	{if $document.name}
	<h1>{$document.name}</h1>
	{/if}
	{$document.text}
{/if}

        </div><!-- /.blog-main -->

        <div class="col-sm-3 col-sm-offset-1 blog-sidebar">
        
        
        
        
	<!-- sideblock -->
	{include file="$themePath/widget/sideblock.tpl"}
        
        
         

      </div><!-- /.row -->

    </div><!-- /.container -->


{include file="$themePath/widget/footer.tpl"}
