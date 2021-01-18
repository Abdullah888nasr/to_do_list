
            <?php 
                foreach(glob($js.'*.js') as $jsFile):
                    echo '<script src="'.$jsFile.'"></script>';
                endforeach;
            ?>
    </body>
</html>