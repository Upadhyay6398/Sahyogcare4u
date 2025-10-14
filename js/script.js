$(document).ready(function(){
    $(".owl_content").owlCarousel({
      rewindNav: false,
      addClassActive: true, //important
      mouseDrag: false,
      afterAction: function add_mid_class(el){
        $('.owl-item')                     
          .removeClass('middle')
          .removeClass('middle_beside')
          .removeClass('next_to_mid')
          .removeClass('prev_to_mid');
        var middle_item = Math.floor($('.active').length / 2);
        middle_item --;
        $('.active').eq(middle_item - 1).addClass('middle_beside');
        $('.active').eq(middle_item).addClass('middle');
        $('.active').eq(middle_item + 1).addClass('middle_beside');
        $('.active').eq(middle_item + 1).nextAll().addClass('next_to_mid');
        $('.active').eq(middle_item - 1).prevAll().addClass('prev_to_mid');
      }
    });
  
    var owl = $(".owl_content").data('owlCarousel');
    $('.owl_wrapper .next').click(function(){owl.next();});
    $('.owl_wrapper .prev').click(function(){owl.prev();});
  });