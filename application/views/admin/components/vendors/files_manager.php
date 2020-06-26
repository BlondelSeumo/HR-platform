<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>skin/app-assets/vendors/css/ui/jquery-ui.css"/>
<script type="text/javascript" src="<?php echo base_url();?>skin/app-assets/vendors/js/ui/jquery-ui.min.js"></script>

<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>skin/vendor/elfinder/css/elfinder.min.css">
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>skin/vendor/elfinder/css/theme.css">

<script src="<?php echo base_url('skin/vendor/elfinder/js/elfinder.min.js'); ?>"></script>
<script type="text/javascript" charset="utf-8">
     $(document).ready(function() {
        $('#elfinder').elfinder({
            url: '<?php echo site_url()?>admin/files/elfinder_init',  // connector URL (REQUIRED)
			uiOptions: {
                // toolbar configuration

                toolbar: [
                    ['back', 'forward'],
//                     ['mkdir'],
                    ['mkdir', 'mkfile', 'upload'],
                    ['open', 'download', 'getfile'],
                    
                    ['quicklook'],
                    ['copy', 'cut', 'paste'],
                    ['rm'],
                    ['duplicate', 'rename', 'edit', 'resize'],
                    ['extract', 'archive'],
                    ['search'],
                    ['view'],
                ],
            }

        });
    });
</script>