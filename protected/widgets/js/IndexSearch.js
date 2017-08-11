/* Global Variables */
var show_children = true;
var last_search_pos;
/* End of Global varaibles */

/*
  * jQuery Search Widget:
  * Generic code that shows, hides and highlights text in a HTML structure
  * that has been generated by eyedrawconfigload yii command
*/
(function($) {
  "use strict";
  let opts;
  let search_term;
  $.fn.search = function(options) {
    opts = $.extend({}, $.fn.search.defaults, options);
    let $results = $("#results");
    let $parent = $results.parent();
    this.keyup(function() {
      $results.detach();
      search_term = ($(this).val() + "").toLowerCase();
      for (let selector of opts.selectors) {
        const last_level = opts.selectors[0] == selector;
        $results.find(selector).each(function() {
          let $this = $(this);
          let $element = get_element($this);
          const allias = $this.data("allias").toLowerCase();
          if (allias.indexOf(search_term) == -1) {
            $this.html($this.text());
            if (!last_level && $element.children().find("li[style!='display: none;']").length != 0) {
              $element.show();
            } else {
              $element.hide();
            }
          } else {
            const highlighted_string = replace_matched_string($this.text(), search_term);
            $this.html(highlighted_string);
            $element.show();
            if (!last_level) {
              if (show_children == true) {
                $element.children().find("li[style='display: none;']").show();
              }
            }
          }
        });
      }
      $results.find("li[style!='display: none;']").find('.allias').each(function(){
        let $this = $(this);
        const highlighted_alliases = replace_matched_string($this.text(), search_term);
        $this.html(highlighted_alliases);
      });
      $parent.append($results);
    });
    return this;
  };
  $.fn.search.defaults = {
    selectors: [".lvl3", ".lvl2", ".lvl1"],
    ancestor_to_change: 2,
    matched_string_tag: ["<em class='search_highlight'>", "</em>"]
  };

  function replace_matched_string(old_string, search_term) {
    if (search_term === undefined || search_term === "" || old_string.toLowerCase().indexOf(search_term.toLowerCase()) == -1) {
      return old_string;
    }
    if (old_string === "") {
      return "";
    }
    const match_start = old_string.toLowerCase().indexOf("" + search_term.toLowerCase() + "");
    const match_end = match_start + search_term.length - 1;
    const before_match = old_string.slice(0, match_start);
    const match_text = old_string.slice(match_start, match_end + 1);
    const after_match = old_string.slice(match_end + 1);
    const new_string = before_match + opts.matched_string_tag[0] + match_text + opts.matched_string_tag[1] + replace_matched_string(after_match, search_term);
    return new_string;
  }

  function get_element($this) {
    for (let i = 0; i < opts.ancestor_to_change; i++) {
      $this = $this.parent();
    }
    return $this;
  }
}(jQuery));
/* End of jQuery Search Widget*/


/*
  * Initialisation:
  * Attaches event listeners to the DOM
  * for the IndexSearch Widget
*/
$(document).ready(function(){
  $("#search_bar_right").search();
  $("#search_bar_left").search();
  $("#search_bar_right").focus(function(){
    $('#search_bar_left').val('');
    last_search_pos = "right";
    $('#search_bar_right').trigger("keyup");
    show_results();
  });
  $("#search_bar_left").focus(function(){
    $('#search_bar_right').val('');
    last_search_pos = "left";
    $('#search_bar_left').trigger("keyup");
    show_results();
  });

  $('.result_item, .result_item_with_icon').click(function(){
    //Index has been clicked
    let $this = $(this);
    index_clicked($this);
    hide_results();
  });
  $('body').append('<div id="dim_rest" class="ui-widget-overlay" style="display : none; width: 1280px; height: 835px; z-index: 100;"></div>');
  $('#description_toggle').change(function(){
    if (this.checked) {
      $('.description_icon,.description_note').show();
    } else {
      $('.description_icon,.description_note').hide();
    }
    event.stopPropagation();
  });
  $('#children_toggle').change(function(){
    let current_search_bar = "#search_bar_"+last_search_pos;
    if (this.checked) {
      show_children = true;
      $(current_search_bar).trigger('keyup');
    } else {
      show_children = false;
      $(current_search_bar).trigger('keyup');
    }
    event.stopPropagation();
  });

  $(window).click(function() {
    hide_results();
  });

  $('.switch').click(function(){
    event.stopPropagation();
  });

  $('#results').click(function(){
    event.stopPropagation();
  });
  $('#search_bar_right,#search_bar_left').click(function(){
    event.stopPropagation();
  });
  $('#big_cross').click(function(){
    hide_results();
  });

});
/* End of Initialisation */


/*
  * Auxilary Functions:
  * Frequently used code
*/
function get_controls_id(elementId, position){
  return "#ed_canvas_edit_"+position+"_"+elementId+"_controls";
}

function get_doodle_button(elementId, doodleClassName, position) {
  let doodle_id = "#"+doodleClassName+position+"_"+elementId;
  let $item = $(doodle_id).children();
  return $item;
}

function show_results(){
  var body = document.body,
  html = document.documentElement;
  var height = Math.max( body.scrollHeight, body.offsetHeight,
    html.clientHeight, html.scrollHeight, html.offsetHeight );
    $('#dim_rest').css("height", height);
    $('#dim_rest').show();
    $("body").css("overflow","hidden");
    $("#results").show();
    $(".switch").show();
    $("#description_toggle_label,#children_toggle_label,#search_options").show();
  }

  function hide_results(){
    $('#search_bar_right,#search_bar_left').val('');
    $('#results').scrollTop(0);
    $('#dim_rest').hide();
    $("body").css("overflow","auto");
    $("#results").hide();
    $(".switch").hide();
    $("#description_toggle_label,#children_toggle_label,#search_options").hide();
  }
  /*End of Auxilary Functions*/


  /*
    * Action Code
    * Code that handles what happens when
    * an index is clicked
  */
  /* Promise wrapper for old-style callback method */
  function index_clicked($this){
    let parameters = {};
    parameters["element_name"] = $this.data('elementName');
    parameters["element_id"] = $this.data('elementId');
    parameters["doodle_name"] = $this.data('doodleClassName');
    parameters["property_name"] = $this.data('property');
    //Chains can be made conditional based on content of parameters
    //Guarantees funcion execution order (even for asyncrounous functions)
    click_element(parameters).then(result => click_doodle(result)).then(result => click_property(result)).catch(() => {
      return;
    });
  }

  function click_element(parameters){
    //get side bar item
    let $item = $(".oe-event-sidebar-edit li a:contains("+parameters.element_name+")");
    return click_sidebar_element($item).then(function (){
      return new Promise(function(resolve, reject) {
        //see if parameters are set for doodle
        if (parameters.doodle_name) {
          resolve(parameters);
        } else {
          reject();
        }
      });
    });
  }

  function click_doodle(parameters){
    // TODO: Stop using timeout and instead use Promise on event handlers (canvas ready)
    // is await the solution (canvas ready)?
    return new Promise(function(resolve, reject) {
      let ed_canvas = ED.Checker.getInstanceByIdSuffix(last_search_pos+"_"+parameters.element_id);
      ED.Checker.register(ed_canvas);
      ED.Checker.onAllReady(function(){
        let dropdown_box_selector = "#eyedrawwidget_"+last_search_pos+"_"+parameters.element_id;
        let $doodle = get_doodle_button(parameters.element_id,parameters.doodle_name,last_search_pos);
        let doodle_name = ED.titles[parameters.doodle_name];
        let $selected_doodle = $(dropdown_box_selector).find("#ed_example_selected_doodle").children().find("option:contains("+doodle_name+")");
        if ($selected_doodle.length == 0) {
          ed_canvas.addDoodle(parameters.doodle_name);
        } else {
          $(dropdown_box_selector).find("#ed_example_selected_doodle").children().find("option").removeAttr('selected');
          $selected_doodle.attr('selected','selected');
          $(dropdown_box_selector).find("#ed_example_selected_doodle").trigger('change');
        }
        //Ensures Promise chains breaks if parameter(s) for next promise are not present
        if (parameters.property_name) {
          resolve(parameters);
        } else {
          reject();
        }
      });
      //wrap onAllReady in Promise
  });
}

  function click_property(parameters){
    return new Promise(function(resolve, reject) {
      let control_id = get_controls_id(parameters.element_id,last_search_pos);
      $(control_id).find("div:contains("+parameters.property_name+")").effect("highlight", {}, 6000);
      /* Breaks the Promise chain as nothing should be called after property,
         based on the current code */
      if (1 == 2) {
        resolve(parameters);
      } else {
        reject();
      }
    });
  }

  function click_sidebar_element($item) {
    return new Promise(function(resolve, reject) {
      event_sidebar.loadClickedItem($item,{},resolve);
    });
  }
  /* End of Promise code*/
