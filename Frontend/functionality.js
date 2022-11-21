
const like_images = document.querySelectorAll(".heart_img");
const imageHandler = (e) => {
    if (e.srcElement.attributes[2].value == "./empty_heart.png"){
        e.srcElement.attributes[2].value = "./full_heart.png";
    }
    else{
        e.srcElement.attributes[2].value = "./empty_heart.png";
    }
};
like_images.forEach(b => b.addEventListener("click",imageHandler));

console.log(like_images);
