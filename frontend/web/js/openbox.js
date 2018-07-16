                function openbox(id, btnid){
        document.getElementById(btnid).style.display = 'none';

            display = document.getElementById(id).style.display;
            if(display=='none'){
               document.getElementById(id).style.display='inline-block';
            }else{
               document.getElementById(id).style.display='none';
            }
        }