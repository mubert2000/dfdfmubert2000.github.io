$(function()
{


				$('.bxslider').bxSlider({
                    auto: true,
                    pause: 7000,
                    nextText: 'Onward >',
                    prevText: '< Go back'
                });
                $('.bxslider2').bxSlider({
                    auto: true,
                    pause: 7000,
                    nextText: 'Onward >',
                    prevText: '< Go back'
                });
                /*$('#slider').cycle({
                    fx:     'fade',
                    rev: 1
                });	 */

calc();

/*deposit plan*/
$('#radio_8').parent().parent().addClass('active');
//$('#radio_1').parent().find('abbr').animate({'right':'4px'},200);
//$('#radio_1').parent().find('a.button').text('выбран');
$('.block-deposit-make > li').find('input').css('display','none');

$(document).on('click','.block-deposit-make > li',function()
{
	 	var $this=$(this);
	 	var a=$(this).attr('id');
	 	$('.block-deposit-make > li').removeClass('active');
	  	$('#radio_'+a).prop('checked', true);
	 	$('#radio_'+a).parent().parent().addClass('active');
	 	//$('.block-deposit-make > li').find('a.button').text('выбрать');
	 	//$this.find('a.button').text('выбран');
});

$('.plan-select').on('click', function()
{
	//$('.grid').css({'display':'none'});
	$(".plan-select").removeClass('act');
	$(this).addClass('act');

	calc();
});

$( "#drag" ).draggable({cursor: "e-resize", axis: "x" ,containment: "parent", drag: function(event, ui)
	{
		var plan=$('.plan-select.act').children('span');
		var min=plan.data('min');
		var max=plan.data('max');
		var percent=plan.data('percent');
		var days=plan.data('days');
		var c=ui.position.left;
 		var e=parseFloat(min)+c*(max-min)/($(this).parent().width()-$(this).width());
		$('.redl').css({'width': c});
 		var output=Math.round(e).toFixed(0)*100/100;
		$('.amount').html(output);
 		calculate(output,percent,days);
	}
});

/* other function*/


function isNumberKey(event)
{
	var charCode = (event.which) ? event.which : event.keyCode;
	if (charCode > 31 && (charCode < 48 || charCode > 57))
		return false;
	return true;
}

function calculate(summ,percent,days)
{
	var total_profit=Math.round(summ*percent).toFixed(0)/100;

	$('.calc-days').html(days);
	$('.calc-profit').html(total_profit+'$');
}

function calc()
{
	var plan=$('.plan-select.act').children('span');
	var min=plan.data('min');
	var max=plan.data('max');
	var id=plan.data('id');
	$('.grid-value-'+id).css({'display':'block'});
	var days=plan.data('days');
	var percent=plan.data('percent');
	$('.amount').html(min);
	$('.redl').animate({'width': '0px'},400);
	$('#drag').animate({'left': '0px'},400);
	calculate(min,percent,days);
}





});


