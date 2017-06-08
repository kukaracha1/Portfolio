var n=8;
var blockSize = 100;
var color = ["#f99909" , "#7c4e09"];
var abc = "ABCDEFGHIJK";
var figure1 = "ЛКСФКСКЛ" , figure2 =  "ЛКСКФСКЛ";
var field;

var collection;
var highlight;
var point;

var Eraser = [];
var eraserMas = { black:[] , white:[]};

function newDiv(className="", colorName="" , innerHTML="", id="" , element=document.body.children["MainField"] , listenerEvent="" , listenerFunction="")
{
        // создаем блок
        var figure = document.createElement('div');
        //назначаем свойства
        if (className!="")
            figure.className = className;    
        if (colorName!="")
            figure.style.background = colorName;
        if (innerHTML!="")
            figure.innerHTML = innerHTML;
        if (id!="")
            figure.id = id;
        
        // if (className=="block")
        //     figure.style.width = figure.style.height = blockSize+"px";


        if (listenerEvent!="" && listenerFunction!="")
            figure.addEventListener(listenerEvent,listenerFunction);
        
        // рисуем
        element.appendChild(figure);
        // возвращаем его же(на всякий случай)
        return figure;
}

function drawEraser()
{
    var mainEraser = newDiv("" , "" , "" , "MainEraser" , document.body);

     Eraser[0] = newDiv("eraser" , "" , "", "black" , mainEraser);
    // Eraser.width = "600px";
    // Eraser.height = "600px";

    Eraser[1] = newDiv("eraser" , "" , "", "white" ,mainEraser);
    // Eraser.width = "600px";
    // Eraser.height = "600px";
}

function getField()
{
    field = new Array(n);

    for(var i = 0 ; i<n ; i++)
    {
        field[i] = [];
      for(var j = 0 ; j<n ; j++)
          field[i][j] = document.getElementById((i+1) + "|" + (j+1));
    }

 //   console.log(field);
}

function figures(j , i)
{
    if (i==1 || i==n-2)
        return "П";
    if (i != 0)
        return figure1.charAt(j);
    return figure2.charAt(j);
}

function background(i,j)
{
    var path = "url(img/";
    if (i == 0)
        {
            if(j>4)
                j = Math.abs(j-n+1);
            path += "0."+j+".png)";     // фигуры черные
            // return "img/0."+j+".png";
        }
    if (i==n-1)
    {
            if(j>4)
                j = Math.abs(j-n+1);
            path += "1."+j+".png)";     // фигуры белые
            // return "img/1."+j+".png";
        
    }
    if (i == 1)
        path += "1.png)";   //пешки черные
        //return "img/1.png";
    if (i== n-2) 
        path += "2.png)";      // пешки белые
       // return "img/2.png";


       path += " no-repeat";

       return path;
}

function idColor(i)
{
    var path = "url(img/";
    if (i == 0 || i==1)
        {
           return "black";
        }
    if (i==n-1 || i== n-2) 
       return "white"
}
function drawFigures()
{
    
    for (var i = 0 ; i < n ; i++)
    {
        for(var j = 0 ; j<n ; j++)
       newDiv("figure" , background(i,j) ,"" ,idColor(i,j) , field[i][j] );
        // newDiv("figure" , "" ,"<img src=\"" + background(i,j) + "\" >" ,"" , field[i][j] );
    }
}

function setHeightAsWidth(div)
{
    div.style.height = div.style.width;
    console.log(div.height + "|"+ div.width);
    console.log(div);
    return div;
}

function drawField()
{
    n = 8;
    var flag = 0;
 
    for(var i = 0 ; i<n + 2 ; i++)
    {        
        for(var j = 0 ; j<n + 2 ; j++)
        {
    // рисуем буквы/цифры
            if (i==0 || i==n+1)
              {
                 var tmp = (newDiv( "text center" , "" , (j!=0 && j!=n+1)? j : ""  ));
                if (tmp.innerHTML == "")
                    tmp.style.width = "5%";//50px";
                // else
                //     tmp.style.width = "1%";//"100px";
 
              }
                    else
                    {
                            // рисуем буквы
                        if (j==0 || j==n+1)
                    {
                        newDiv( "text side" , "" , abc[i-1] );
                    }
                    else
                    {
                // рисуем квадратик
                        setHeightAsWidth(newDiv( "block" , color[flag] , "" , i + "|" + j));
                       
                        // меняем цвет
                        flag = (flag==0)? 1 : 0;
                    }
        }

        }
        
        flag = (flag==0)? 1 : 0;
        newDiv( "clear");

    
    }
}

function getPixelOfPercent(number , percent)
{
    return number*percent/100;
}

// выделяет выбранную ячейку
function figureClick( i)
{
    console.log("it's figureClick: "+ this);
    var borderSize = 1;
    var thisStyle;
    //убираем выделение у предыдущего блока
    if (highlight || highlight==0)
        {
            thisStyle = getComputedStyle(collection[highlight]);
            // collection[highlight].style.border = "none";
            // collection[highlight].style.width = (parseFloat( collection[highlight].style.width) + borderSize*2) + "%";
            // collection[highlight].style.height = (parseFloat( collection[highlight].style.height) + borderSize*2) + "%";



    collection[highlight].style.border = "none";
    collection[highlight].style.width = getPixelOfPercent( parseFloat( collection[highlight].style.width) , 10)  + "%";
    collection[highlight].style.height = getPixelOfPercent( parseFloat( collection[highlight].style.height) , 7) + "%";
           

        }

    thisStyle = getComputedStyle(collection[i]);
    // выделяем выбранный блок

    // размеры родительского блока в пикселях
    var parentWidth = parseFloat(thisStyle.width) * 100/10;         
    var parentHeight = parseFloat(thisStyle.height) * 100/7;

    // величина бордера в пикселях
    // var borderTop = getPixelOfPercent( parentHeight,7) - getPixelOfPercent( parentHeight,6);
    // var borderLeft = getPixelOfPercent( parentWidth,10) - getPixelOfPercent( parentWidth,9);
    var borderTop = 0;
    var borderLeft = 0;

     collection[i].style["border-left"] = collection[i].style["border-right"] = borderLeft + "px solid yellow";
     collection[i].style["border-top"] = collection[i].style["border-bottom"] = borderTop + "px solid yellow";
     collection[i].style.width =  getPixelOfPercent( parseFloat( collection[i].style.width) , 9)  + "%";
     collection[i].style.height = getPixelOfPercent( parseFloat( collection[i].style.height) , 6) + "%";
    //alert( collection[i].style.width );
    
    point.innerHTML = abc[collection[i].id[0] - 1] + collection[i].id[2] ;


    highlight = i;
}


function figureKey(e , selectFigure = highlight)
{
    //var selectFigure = highlight;

    console.log(e);
    if (e.key == "d")
    {
        selectFigure += 1;
        if (selectFigure%8 == 0 )
            selectFigure = figureKey({key:"w"} , selectFigure);
    }
    if (e.key == "a")
    {        
        if (selectFigure%8 == 0 )
            selectFigure = figureKey({key:"s"} , selectFigure-1);
        else
            selectFigure -= 1;
   }
    if (e.key == "w")       // UP
    {        
        selectFigure -= 8;
        if ( ! collection[selectFigure])
            selectFigure += 8*8; 
    }
        if (e.key == "s")
    {
        selectFigure += 8;
        if (!collection[selectFigure])
            selectFigure -= 8*8;
    }
        if (collection[selectFigure])
            figureClick( selectFigure);
    
    return selectFigure;
}

function eraser(i)
{
//    alert("test alert");

    // сохраняем фон у потомка текущего блока
    var tempBackground = this.firstChild.style.background;
    console.log(tempBackground);

    if(tempBackground != "")
    {
        // получаем два блока с удаленными
       // var eraseBox = document.getElementsByClassName("eraser");
      
       var j = (this.firstChild.id=="white")? 1 : 0;
        //добавляем в один из них
        var selectItem = newDiv("eraser-item" , tempBackground ,"" ,"" , Eraser [ j ]);
        
        this.firstChild.style.background = "";

    //     var indexOfEraser = (eraserMas.length)? eraserMas.length : 0;
    //    eraserMas[this.firstChild.id][indexOfEraser] = i;  

       selectItem.addEventListener("dblclick",recover.bind(selectItem , i));
    }

    // for (var i = eraserMas.length-1 ; i < erasedFigure.length ; i++)
    // {
    //     erasedFigure[i].addEventListener("dblclick",recover.bind(erasedFigure[i] , i));
    // }
    //-------------------------------------------------------------------------------
}

function recover(i)
{
  //  alert("recover start: " +i);
  //  console.log(erasedFigure);
  //  console.log(eraserMas);

if (this.style.background != "")
{
   collection[i].firstChild.style.background = this.style.background;
   this.style.background = "";
   this.remove();
   }//   alert("recover complete");
}

// устанавливает слушатель на клик
function setFigureListener()
{

    collection = document.getElementsByClassName("block");

    for(var i = 0 ; i < collection.length ; i++)
    {
        collection[i].addEventListener("click" , figureClick.bind(collection[i],i) );
        collection[i].addEventListener("dblclick",eraser.bind(collection[i] ,i));
    }

    window.addEventListener("keypress" , figureKey.bind(window));

    // получаем коллекцию удаленных фигур
    
   // window.addEventListener("dblclick" , eraser);
 
}


function main()
{
   console.log("I'm here");
    point = newDiv("text","","","point" , document.body);

    Eraser[0] = newDiv("eraser" , "" , "", "black" , document.body);
 
    newDiv("" , "" , "" , "MainField" , document.body);
    drawField();
    
    getField();

    drawFigures();

    Eraser[1] = newDiv("eraser" , "" , "", "white" , document.body);

//    drawEraser();

    setFigureListener();

}