function ajax(method, url, success){

    let xhr = new XMLHttpRequest();

    xhr.addEventListener('readystatechange', function(){

        if(xhr.status == 200 && xhr.readyState == 4){
            success(xhr.response);
        }

    }, false);

    xhr.open(method, url, true);
    xhr.send();

}

export default ajax;