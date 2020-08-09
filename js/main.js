window.addEventListener("load", documentLoaded);

function documentLoaded() {
    document.getElementById('commanderpreview').addEventListener('click',function(evt){
        eDiv=document.getElementById('hidden');
        eDiv.style.display="flex";
        document.getElementById("non").addEventListener('click',function(){
            eDiv.style.display="none";
        })
    });
}