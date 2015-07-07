			var stopBlur = false;
			a.html("<textarea "+title+"name=\"textarea\" id=\""+ a.attr('id') +"_field\" class=\"ckeditor\">" + a.html() + "</textarea>");
            if (window.CKEDITOR) {
                setTimeout( function() { $( '.cke_editable' ).focus() }, 500 );
                CKEDITOR.inline( 'textarea', { on: { blur: function( event ) { var data = event.editor.getData(); fieldSave(a.attr('id'), data ) } } } );
            } else {
                editor = a.find('textarea');
                editor.jqte({focus: function(){stopBlur=true;setTimeout(function(){stopBlur=false;},200);},blur: function(){setTimeout(function(){if(stopBlur)return;fieldSave(a.attr('id'),a.find('div.jqte_editor').html());},50)}});
                $('div.jqte_tool').click(function(){
                    stopBlur = true;
                    setTimeout(function(){stopBlur = false;},200);
                    a.find('div.jqte_editor').focus();
                });
                $('.jqte_linkinput').click(function(){
                    stopBlur = true;
                    setTimeout(function(){a.find('div.jqte_editor').focus();},20000);
                });
                a.find('div.jqte_editor').focus();
            }

			
			