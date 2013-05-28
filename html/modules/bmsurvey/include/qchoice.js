<!--
    // Make a Top selection
    var bunruiA = new Array(
    	"Archived",
    	"Edit",
    	"Test",
    	"Active",
    	"Finished"
    );
 
    // 次の分類(分類Aごとの分類Bリスト)を定義
    var bunruiB = new Array();
    bunruiB["野菜"]= new Array("じゃがいも","にんじん","ピーマン");
    bunruiB["果物"]= new Array("スイカ(1/4)","オレンジ","いちご");
    bunruiB["肉"]  = new Array("豚肉(100g)","牛肉(100g)","羊肉(100g)");
    bunruiB["魚"]  = new Array("サンマ(1尾)","アジ(1尾)","しらす(小パック)");
 
    // 分類Aの選択リストを作成
    createSelection( form1.elements['sel_bunruiA'], "(type)", bunruiA, bunruiA)
 
    ////////////////////////////////////////////////////
    //
    // 選択ボックスに選択肢を追加する関数
    //    引数: ( selectオブジェクト, value値, text値)
    function addSelOption( selObj, myValue, myText )
    {
        selObj.length++;
        selObj.options[ selObj.length - 1].value = myValue ;
        selObj.options[ selObj.length - 1].text  = myText;
 
    }
    /////////////////////////////////////////////////////
    //
    //    選択リストを作る関数 
    //    引数: ( selectオブジェクト, 見出し, value値配列 , text値配列 )
    //
    function createSelection( selObj, midashi, aryValue, aryText )
    {
        selObj.length = 0;
        addSelOption( selObj, midashi, midashi);
        // 初期化
        for( var i=0; i < aryValue.length; i++)
        {
            addSelOption ( selObj , aryValue[i], aryText[i]);
        }
    }
    ///////////////////////////////////////////////////
    //
    //     分類Aが選択されたときに呼び出される関数
    //
    function selectBunruiA(obj)
    {
        // 選択肢を動的に生成
        createSelection(form1.elements['sel_bunruiB'], "(品名)", 
                bunruiB[obj.value], bunruiB[obj.value]);
 
    }
    /////////////////////////////////////////////////
    // submit前の処理
    function gettext(form){ 
        var a = form1.sel_bunruiA.value;   // 分類1
        var b = form1.sel_bunruiB.value;   // 分類2
        // ANDでつなげる
        form1.elements['search'].value = a+' AND '+b;
        alert(form1.elements['search'].value );
    } 
 
//-->
