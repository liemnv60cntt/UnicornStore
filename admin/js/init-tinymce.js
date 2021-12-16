tinyMCE.init({
    mode : "textareas",
    theme: "silver",
    width: "100%",
    height: 300,
    statusbar: true,
    plugins : "emotions,spellchecker,advhr,insertdatetime,preview,table",

    // Theme options - button# indicated the row# only
    theme_advanced_buttons1 : "newdocument,|,bold,italic,underline,|,justifyleft,justifycenter,justifyright,fontselect,fontsizeselect,formatselect",
    theme_advanced_buttons2 : "cut,copy,paste,|,bullist,numlist,|,outdent,indent,|,undo,redo,|,link,unlink,anchor,image,|,code,preview,|,forecolor,backcolor",
    theme_advanced_buttons3 : "insertdate,inserttime,|,spellchecker,advhr,,removeformat,|,sub,sup,|,charmap,emotions,tablecontrols",      
    theme_advanced_toolbar_location : "top",
    theme_advanced_toolbar_align : "left",
    theme_advanced_statusbar_location : "bottom",
    theme_advanced_resizing : true,
    table_styles : "Header 1=header1;Header 2=header2;Header 3=header3",
    table_cell_styles : "Header 1=header1;Header 2=header2;Header 3=header3;Table Cell=tableCel1",
    table_row_styles : "Header 1=header1;Header 2=header2;Header 3=header3;Table Row=tableRow1",
    table_cell_limit : 100,
    table_row_limit : 5,
    table_col_limit : 5
    });