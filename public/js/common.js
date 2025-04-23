/* ---------------------------------------------- /*
 * Scroll top/*
---------------------------------------------- */


       /* ---------------------------------------------- /*
         * Scroll top
         /* ---------------------------------------------- */

         $(window).scroll(function() {
          if ($(this).scrollTop() > 100) {
              $('.scroll-up').fadeIn();
          } else {
              $('.scroll-up').fadeOut();
          }
      });
      $(function(){
        $(document).on('click', 'a[href="#totop"]', function(){
          $('html, body').animate({ scrollTop: 0 }, 'slow');
          return false;
        });
      });

    $(function(){
      $(document).on('click', '.table-ttl', function(){
        var t = $(this).find(".table-icon");
        t.toggleClass("active-click");
      });
    });


