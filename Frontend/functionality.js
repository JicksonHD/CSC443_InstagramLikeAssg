
const like_images = document.querySelectorAll(".heart_img");
const comment_icons = document.querySelectorAll(".comment");
const add_comment = document.getElementById("add_comment");
const remove_comment_box = document.getElementById("x_icon");

const imageHandler = (e) => {
    if (e.srcElement.attributes[2].value == "./empty_heart.png"){
        e.srcElement.attributes[2].value = "./full_heart.png";
    }
    else{
        e.srcElement.attributes[2].value = "./empty_heart.png";
    }
};


const commentHandler = (c) => {

    add_comment.style.display = "flex";

};

const xicon = (x) => {

    add_comment.style.display = "none";
}

like_images.forEach(b => b.addEventListener("click",imageHandler));
comment_icons.forEach(b => b.addEventListener("click",commentHandler));
remove_comment_box.addEventListener("click", xicon);

