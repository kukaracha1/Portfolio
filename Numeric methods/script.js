var answer;


function Laba3()
{
    var methodList,
        funct = $( '<input/>' , {
            class: 'function col-md-7' ,
            type: 'text' ,
            value : '4* x *log( x )*log( x ) - 4*sqrt(1+ x ) + 5'
         } ),
        a = $('<input/>' , { 
            class: 'a col-md-2' , 
            type: 'number',
            size: 5,
            value: 0.1
        } ),
        b = $('<input/>' , { 
            class: 'b col-md-2' , 
            type: 'number',
            size: 5,
            value: 1
        } ),
        accuracy = $('<input/>' , {
            type:"number",
            class:"accuracy col-md-7",  
            value:"0.001"
        }),
        method = $('<select/>' , {
            class:"method col-md-7",  
        }),
        equateBtn = $('<button/>' , {
            class : "equate btn btn-success",
            text: 'Equate'
          }),
        answer = $('<div/>' , {
            class: 'answer col-md-7'
        }),
        funcText = $('<div/>' , {
            class: 'fText col-md-12'
        }), 
        del = $('<button/>' , {
            text: 'Delete',
            class: 'btn btn-danger'
        }),
        form = $('<form/>' , {
            class: "col-md-5"
        })
        .append($('<span/>' , {
            class : 'col-md-5',
            text : 'Function is:'
        }))
        .append($(funct))
        .append($('<div/>' , { class : 'clear'}))
        .append($('<span/>' , {
            class : 'col-md-5',
            text : 'Interval from:'
        }))  
        .append($(a))
        .append($('<span/>' , {
            class : 'col-md-3',
            text : 'to'
        }))        
        .append($(b))      
        .append($('<div/>' , { class : 'clear'}))
        .append($('<span/>' , {
            class : 'col-md-5',
            text : 'Accuracy:'
        }))  
        .append($(accuracy))
        .append($('<div/>' , { class : 'clear'}))
        .append($('<span/>' , {
            class : 'col-md-5',
            text : 'Method:'
        })) 
        .append($(method))
        .append($('<div/>' , { class : 'clear'}))
        .append($(equateBtn))
        .append($(del))
        .append($('<div/>' , { class : 'clear'}))
        .append($(funcText)),
        div = $('<div/>' , {
            class : 'laba3 row'
        }).append( $(form)).append($(answer));

    $.ajax({
            type:   "GET",
            url:    "methods.json",
            dataType: 'json'
        }   
    )
    .done(function(msg) {
        methodList = msg;
        $(method).append($('<option/>' , {
                text    :   'All methods'
            }));
        for (var i = 0; i < msg.length; i++) {
            var element = msg[i];
            $(method).append($('<option/>' , {
                text : element
            }));
        }
    })
    


    $(equateBtn).click( function(e){
        e.preventDefault();
        $(answer).html("<p>Wait...</p>");
        $(funcText).text( ($(funct).val()).replace(/\*/g , '•').replace(/\ /g , '').replace(/\+/g," + ").replace(/\-/g," - ") + " = 0" );

    
        methods = [ ];

        if ( $(method).val() == 'All methods')
        {
            methods = methodList;
        }
        else 
        methods.push($(method).val());

            
        var json =  {
                        function : ($(funct).val()).replace(/\bx\b/ig,'$x'),
                        a : $(a).val(),
                        b : $(b).val(),
                        accuracy : $(accuracy).val(),
                        methods : methods
                    };

                    console.log((json) );
        $.ajax(
            {
                type:   "GET",
                url:    "main.php",
                data:   json
                   
            }   
        )
        .done(function(msg) {
            console.log(msg);
            $(answer).empty();
            var text;
            try {
                data = JSON.parse(msg);
                text = $('<table/>' , {class: 'table table-bordered table-striped'});
                var headerTr = ($('<tr/>' , {class: 'table-bordered'}));
 
                $(text).append($('<thead/>').append(headerTr));
                                
                for (var i=0 ; i<data.length ; i++)
                {    // getting the array of keys
                    var keys = Object.keys(data[i]);
                    var tr = $('<tr/>' , {class: 'table-bordered'});
                    keys.forEach(function(key) {
                        // fill the header row
                        if (i==0)
                            $(headerTr).append($('<th/>', { text : key , class: 'sorting table-bordered'}));
                        // fill data
                        $(tr).append( $('<td/>', { text : data[i][key] , class: 'table-bordered'}) );
                    }, this);
                    
                    $(text).append(tr);
                }
            }
            catch (error) {
                console.log(error);
                text = $('<div/>', {text: error});
                try{
                    console.log('error')
                    console.log(msg);
                    text.append(msg);
                }
                catch(error) {}
            }

            

            // $(text).DataTable();
            $(answer).append($('<tbody/>').append(text));

        })
        .fail(function(error) {
            $(answer).text(error);
            console.log(error);
            
        })
        ;

    }
    );

    $(del).click( function() {
        $(div).remove();    
    });

    return div;
}


$(function() {

$('.add').click( function() {
    $('.wrapper').append( new Laba3());    
});




    

})