function goDeal(dealId, providerCode, metaId) {
	var url = "/landing.html?dealId="+dealId+"&providerCode="+providerCode+"&metaId=" + metaId;
	window.open(url); 
	setTimeout(resetRecentViews, 3000);
}

function resetRecentViews() {
	$.ajax({url:'/recentViews.html?layout=Empty', async:false, data:'', success:function(data) {
		$('#recentViewBox').empty().html(data);
	}});	
}

function goSearch() {
	var form = $('#searchForm');
	form.submit();
}

function valueSelect(obj) {
	obj.focus();
	obj.select();
}

function goSearchType(type, order) {
	$('#type').val(type);
	$('#order').val(order);
	goSearch();
}

function goCart(id) {
    if( id == 0 )
        location.href = "cart.php";
    else
	    location.href = "cart.php?id="+id;
}

function goPage(page) {
	location.href = 'index.php?page='+page;
}

function goMainMenu(url) {
	location.href = url;
}
function goSubMenu(mainMenuId, subMenuId) {
	location.href = '/main.html?mainMenuId='+mainMenuId+'&subMenuId='+subMenuId;
}

//스크롤링 속도는 "var speed = 5;"에서 "5" 부분을 원하시는 숫자로 지정해주시면 됩니다.
function goTop(orix, oriy, desx, desy) {
    var Timer = null;
    var winHeight= 0;
    if (document.body.scrollTop == 0) {
        winHeight = document.documentElement.scrollTop;
    } else {
        winHeight = document.body.scrollTop;
    }
    if(Timer) clearTimeout(Timer);
    startx = 0;
    starty = winHeight;
    if(!orix || orix < 0) orix = 0;
    if(!oriy || oriy < 0) oriy = 0;
    var speed = 5;
	// 스크롤링 속도조절: var speed = '숫자';
	// 높으면 높을수록 빨라짐.
    if(!desx) desx = 0 + startx;
    if(!desy) desy = 0 + starty;
    desx += (orix - startx) / speed;
    if (desx < 0) desx = 0;
    desy += (oriy - starty) / speed;
    if (desy < 0) desy = 0;
    var posX = Math.ceil(desx);
    var posY = Math.ceil(desy);
    window.scrollTo(posX, posY);
    if((Math.floor(Math.abs(startx - orix)) < 1) && (Math.floor(Math.abs(starty - oriy)) < 1)){
        clearTimeout(Timer);
        window.scroll(orix,oriy);
    }else if(posX != orix || posY != oriy){
        Timer = setTimeout("goTop("+orix+","+oriy+","+desx+","+desy+")",15);
    }else{
        clearTimeout(Timer);
    }
}

dimmed = {
  obj:null,
  on:function(){
         this.obj  = $('<div class="dimmed"></div>');
         this.obj.appendTo('.wrap');
  },
  off:function(){
         this.obj.remove();
  }
};

function addFavorite(){
	var title = document.title; //현재 보고 있는 페이지의 Title
	var url = location.href; //현재 보고 있는 페이지의 Url
	if (window.sidebar && window.sidebar.addPanel){//firefox
		window.sidebar.addPanel(title, url,"");
	} else if (window.opera && window.print){//opera
		var elem = document.createElement('a'); 
		elem.setAttribute('href',url); 
		elem.setAttribute('title',title); 
		elem.setAttribute('rel','sidebar'); 
		elem.click();
	} else if (document.all){//msie
		window.external.AddFavorite( url, title);
	} else {
		alert("해당브라우저는 즐겨찾기 추가기능이 지원되지 않습니다.\n\n수동으로 즐겨찾기에 추가해주세요.");
		return true;
	}
}
