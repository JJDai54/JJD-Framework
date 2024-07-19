
/**
 *
 * Created with NetBeans IDE
 *
 * Code     : Icon Select JS
 * Version  : 1.0
 *
 * User     : Bugra OZDEN
 * Site     : http://www.bugraozden.com
 * Mail     : bugra.ozden@gmail.com
 *
 * Date     : 10/30/13
 * Time     : 01:10 PM
 *
 */

IconSelect.DEFAULT = {};
IconSelect.DEFAULT.SELECTED_ICON_WIDTH = 48;
IconSelect.DEFAULT.SELECTED_ICON_HEIGHT = 48;
IconSelect.DEFAULT.SELECTED_BOX_PADDING = 1;
IconSelect.DEFAULT.SELECTED_BOX_PADDING_RIGHT = 12;
IconSelect.DEFAULT.ICONS_WIDTH = 32;
IconSelect.DEFAULT.ICONS_HEIGHT = 32;
IconSelect.DEFAULT.BOX_ICON_SPACE = 1;
IconSelect.DEFAULT.VECTORAL_ICON_NUMBER = 8;
IconSelect.DEFAULT.HORIZONTAL_ICON_NUMBER = 1;

IconSelect.DEFAULT.COMPONENT_ICON_FILE_PATH = "arrow.png";
//IconSelect.COMPONENT_ICON_FILE_PATH = "images/control/icon-select/arrow.png";
IconSelect.DEFAULT.INDEX_IMG = 0;


function IconSelect($$elementID, $$xoopsName, $$parameters) {
    
    var _icons = [];
    var _selectedIndex = -1;
    var _boxScroll;
    
    var _default = IconSelect.DEFAULT;
    //$$elementID += '-' + $$suffixe;
    
    function _init() {
        
        //parametreler boş gelirse
        //alert('avant');
        if(!$$parameters) $$parameters = {};
        $$parameters.xoopsName = $$xoopsName;
        //alert('apres : ' + $$parameters.xoopsName);
        //En üst elementi seç
        if(_View.setIconSelectElement($$elementID)){
            
            //set parameters
            $$parameters = _Model.checkParameters($$parameters);

            //create UI
            var ui = _View.createUI($$parameters, $$elementID);
            //basıldığında göster/gizle
            _View.iconSelectElement.onclick = function(){
                _View.showBox();
            };
            
            //Başlangıçta gizle
            _View.showBox(false);

            //Nesneye basıldığında gizlemeyi iptal et.
            _View.iconSelectElement.addEventListener('click', function($event){
                $event.stopPropagation();             
            });
            
            //dışarı basıldığında gizle.
            window.addEventListener('click', function(){
                _View.showBox(false);
            });
           
        }else{
            alert("Element not found.");
        }
        
    }
    
    //Tüm iconları yeniden yükle.
    this.refresh = function($icons){
        
        _icons = [];
        
        var setSelectedIndex = this.setSelectedIndex;
        
        for(var i = 0; i < $icons.length; i++){
            $icons[i].element = _View.createIcon($icons[i].iconFilePath, $icons[i].iconValue, i, $$parameters);
            $icons[i].element.onclick = function(){
                setSelectedIndex(this.childNodes[0].getAttribute('icon-index'));
                
            };
            _icons.push($icons[i]);
            
        }
        
        var horizontalIconNumber = Math.round(($icons.length) / $$parameters.vectoralIconNumber);
        
        _View.boxElement.style.height = (($$parameters.iconsHeight + 2) * horizontalIconNumber) + 
                ((horizontalIconNumber + 1) * $$parameters.boxIconSpace);
        //alert('indexImg = ' + $$parameters.indexImg);
        this.setSelectedIndex($$parameters.indexImg);
    };
    
    //icon listesini al.
    this.getIcons = function(){ return _icons; };
    
    //iconu seçili hale gelir.
    this.setSelectedIndex = function($index){
      //alert('setSelectedIndex : ' + $index);  
        var icon;
        
        if(_icons.length > $index)
            icon = _icons[$index];
        
        if(icon){
            //eski icondan seçilme özelliğini kaldır.
            if(_selectedIndex != -1) _icons[_selectedIndex].element.setAttribute('class','icon');
            _selectedIndex = $index;
            _View.selectedIconImgElement.setAttribute('src', icon.iconFilePath);
            if(_selectedIndex != -1) _icons[_selectedIndex].element.setAttribute('class','icon selected');
        }
        _View.iconSelectElement.dispatchEvent(new Event('changed'));
        //document.getElementById($$parameters.xoopsName).value = $index; //jjdai
        document.getElementById($$parameters.xoopsName).value = _icons[$index].iconValue;
        //alert(_icons[$index].iconValue);
        //_View.showBox(false);
        
    };
    
    this.getSelectedIndex = function(){ return _selectedIndex; };
    this.getSelectedValue = function(){ return _icons[_selectedIndex].iconValue };
    this.getSelectedFilePath = function(){ return _icons[_selectedIndex].iconFilePath };
    
    
    
    //### VIEW CLASS ###
        
    function _View(){}
    
    _View.iconSelectElement;
    _View.boxElement;
    _View.boxScrollElement;
    _View.selectedIconImgElement;
    _View.selectedIconElement;
    
    _View.showBox = function($isShown){
                
         if($isShown == null) {
             $isShown = (_View.boxElement.style.display == "none") ? true : false;
         }
                
        if($isShown) {
            _View.boxElement.style.display = "block";
            _View.boxScrollElement.style.display = "block";
            _boxScroll = (_boxScroll) ? _boxScroll : new iScroll($$elementID + "-box-scroll");
        }else{
            _View.boxElement.style.display = "none";
            _View.boxScrollElement.style.display = "none";
        }
        
        _View.boxElement.style.display = ($isShown) ? "block" : "none";
        
        
            
    };
    
    _View.setIconSelectElement = function($elementID){
        _View.iconSelectElement = document.getElementById($elementID);
        //alert($elementID);
        return _View.iconSelectElement;
    };
    
    _View.clearUI = function(){
        _View.iconSelectElement.innerHTML = "";
    };
    
    _View.clearIcons = function(){
        _View.boxElement.innerHTML = "";
    };
    
    _View.createUI = function($parameters){
        
        /* HTML MODEL
        
        <div id="my-icon-select" class="icon-select">
            <div class="selected-box">
                <div class="selected-icon"><img src="images/icons/i2.png"></div>
                <div class="component-icon"><img src="images/control/icon-select/arrow.png"></div>
                <div class="box">
                    <div class="icon"><img src="images/icons/i1.png"></div>
                    <div class="icon selected"><img src="images/icons/i2.png"></div>
                    <div class="icon"><img src="images/icons/i3.png"></div>
                    <div class="icon"><img src="images/icons/i4.png"></div>
                    <div class="icon"><img src="images/icons/i3.png"></div>
                    <div class="icon"><img src="images/icons/i4.png"></div>
                    <div class="icon"><img src="images/icons/i5.png"></div>
                    <div class="icon"><img src="images/icons/i6.png"></div>
                    <div class="icon"><img src="images/icons/i7.png"></div>
                    <div class="icon"><img src="images/icons/i8.png"></div>
                </div>
            </div>
        </div>
        
        */
        
        _View.clearUI();
        
        _View.iconSelectElement.setAttribute('class', 'icon-select');
        //alert(_View.iconSelectElement.id);
        var selectedBoxElement = document.createElement('div');
        selectedBoxElement.setAttribute('class' ,'selected-box');
        
        var selectedIconElement = document.createElement('div');
        selectedIconElement.setAttribute('class' ,'selected-icon');
        
        _View.selectedIconImgElement = document.createElement('img');
        _View.selectedIconImgElement.setAttribute('src', '');
        selectedIconElement.appendChild(_View.selectedIconImgElement);
        
        var componentIconElement = document.createElement('div');
        componentIconElement.setAttribute('class', 'component-icon');
        
        var componentIconImgElement = document.createElement('img');
        //componentIconImgElement.setAttribute('src', IconSelect.COMPONENT_ICON_FILE_PATH );
        componentIconImgElement.setAttribute('src', $parameters.iconFilePath);
        componentIconElement.appendChild(componentIconImgElement);
        
        _View.boxScrollElement = document.createElement('div');
        _View.boxScrollElement.setAttribute('id',$$elementID + "-box-scroll");
        _View.boxScrollElement.setAttribute('class', 'box');
        
        _View.boxElement = document.createElement('div');
        
        //_View.boxElement.setAttribute('class', 'box');
        _View.boxScrollElement.appendChild(_View.boxElement);
        
        _View.selectedIconImgElement.setAttribute('width', $parameters.selectedIconWidth);
        _View.selectedIconImgElement.setAttribute('height', $parameters.selectedIconHeight);

        selectedIconElement.style.width = $parameters.selectedIconWidth + 'px';
        selectedIconElement.style.height = $parameters.selectedIconHeight + 'px';
        selectedBoxElement.style.width = $parameters.selectedIconWidth + $parameters.selectedBoxPadding + $parameters.selectedBoxPaddingRight + 'px';
        selectedBoxElement.style.height = $parameters.selectedIconHeight + ($parameters.selectedBoxPadding * 2) + 'px';
        selectedIconElement.style.top = $parameters.selectedBoxPadding + 'px';
        selectedIconElement.style.left = $parameters.selectedBoxPadding + 'px';
        componentIconElement.style.bottom = 4 + $parameters.selectedBoxPadding + 'px';
        
        _View.boxScrollElement.style.left = parseInt(selectedBoxElement.style.width) + 1;
        
        //JJDai - modif nombre d'icone horizontaux
        _View.boxScrollElement.style.width = ((($parameters.iconsWidth + $parameters.boxIconSpace) * $parameters.horizontalIconNumber) + 
                (($parameters.horizontalIconNumber + 4) * $parameters.boxIconSpace)) + 'px';
        _View.boxScrollElement.style.height = ((($parameters.iconsHeight + $parameters.boxIconSpace) * $parameters.vectoralIconNumber) + 
                (($parameters.vectoralIconNumber + 2) * $parameters.boxIconSpace)) + 'px';
//alert ("zzz- " + $parameters.horizontalIconNumber  + " - " + $parameters.vectoralIconNumber);        
         
/*
        _View.boxScrollElement.style.width = (($parameters.iconsWidth + 2) * $parameters.vectoralIconNumber) + (($parameters.vectoralIconNumber + 1) * $parameters.boxIconSpace) + 'px';
        _View.boxScrollElement.style.height = (($parameters.iconsHeight + 2) * $parameters.horizontalIconNumber) + (($parameters.horizontalIconNumber + 1) * $parameters.boxIconSpace) + 'px';
*/         
         
        _View.boxElement.style.left = _View.boxScrollElement.style.left + 'px';
        _View.boxElement.style.width = _View.boxScrollElement.style.width + 'px';

         
         
         
        _View.boxElement.style.left = _View.boxScrollElement.style.left;
        _View.boxElement.style.width = _View.boxScrollElement.style.width;
        
        _View.iconSelectElement.appendChild(selectedBoxElement);
        selectedBoxElement.appendChild(selectedIconElement);
        selectedBoxElement.appendChild(componentIconElement);
        selectedBoxElement.appendChild(_View.boxScrollElement);
        
        
        var results = {};
        results['iconSelectElement'] = _View.iconSelectElement;
        results['selectedBoxElement'] = selectedBoxElement;
        results['selectedIconElement'] = selectedIconElement;
        results['selectedIconImgElement'] = _View.selectedIconImgElement;
        results['componentIconElement'] = componentIconElement;
        results['componentIconImgElement'] = componentIconImgElement;
        
        return results;
        
        
       //trigger: created ( run setValues )
        
    };
        
    _View.createIcon = function($iconFilePath, $iconValue, $index, $parameters){
        
        /* HTML MODEL 
         
         <div class="icon"><img src="images/icons/i1.png"></div>
         
         */
        
        var iconElement = document.createElement('div');
        iconElement.setAttribute('class', 'icon');
        iconElement.style.width = $parameters.iconsWidth;
        iconElement.style.height = $parameters.iconsHeight;
        iconElement.style.marginLeft = $parameters.boxIconSpace;
        iconElement.style.marginTop = $parameters.boxIconSpace;
        
        var iconImgElement = document.createElement('img');
        iconImgElement.setAttribute('src', $iconFilePath);
        iconImgElement.setAttribute('icon-value', $iconValue);
        iconImgElement.setAttribute('icon-index', $index);
        iconImgElement.setAttribute('width', $parameters.iconsWidth);
        iconImgElement.setAttribute('height', $parameters.iconsHeight);

       
        
        iconElement.appendChild(iconImgElement);
        _View.boxElement.appendChild(iconElement);
        
        return iconElement;
        
    };
    
    //### MODEL CLASS ###
    
    function _Model(){}
    
    //TODO: params değişkenini kaldır yeni oluştursun.
    _Model.checkParameters = function($parameters){
        
        $parameters.selectedIconWidth          = ($parameters.selectedIconWidth)          ? $parameters.selectedIconWidth        : _default.SELECTED_ICON_WIDTH;
        $parameters.selectedIconHeight         = ($parameters.selectedIconHeight)         ? $parameters.selectedIconHeight       : _default.SELECTED_ICON_HEIGHT;
        $parameters.selectedBoxPadding         = ($parameters.selectedBoxPadding)         ? $parameters.selectedBoxPadding       : _default.SELECTED_BOX_PADDING;
        $parameters.selectedBoxPaddingRight    = ($parameters.selectedBoxPaddingRight)    ? $parameters.selectedBoxPaddingRight  : _default.SELECTED_BOX_PADDING_RIGHT;
        $parameters.iconsWidth                 = ($parameters.iconsWidth)                 ? $parameters.iconsWidth               : _default.ICONS_WIDTH;
        $parameters.iconsHeight                = ($parameters.iconsHeight)                ? $parameters.iconsHeight              : _default.ICONS_HEIGHT;
        $parameters.boxIconSpace               = ($parameters.boxIconSpace)               ? $parameters.boxIconSpace             : _default.BOX_ICON_SPACE;
        $parameters.vectoralIconNumber         = ($parameters.vectoralIconNumber)         ? $parameters.vectoralIconNumber       : _default.VECTORAL_ICON_NUMBER;
        $parameters.horizontalIconNumber       = ($parameters.horizontalIconNumber)       ? $parameters.horizontalIconNumber     : _default.HORIZONTAL_ICON_NUMBER;
    
        $parameters.iconFilePath               = ($parameters.iconFilePath)               ? $parameters.iconFilePath             : _default.COMPONENT_ICON_FILE_PATH;
        $parameters.indexImg                   = ($parameters.indexImg)                   ? $parameters.indexImg                 : _default.INDEX_IMG;
        return $parameters;
    
    };
    
    _init();
    
}
