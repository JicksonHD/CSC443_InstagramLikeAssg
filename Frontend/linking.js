const pages = {};
const base_url = "http://localhost/FinalAssg/Backend/";

pages.Console = (title, values, oneValue = true) => {
  console.log("---" + title + "---");
  if (oneValue) {
    console.log(values);
  } else {
    for (let i = 0; i < values.length; i++) {
      console.log(values[i]);
    }
  }
  console.log("--/" + title + "---");
};

pages.loadFor = (page) => {
  eval("pages.load_" + page + "();");
};

pages.postAPI = async (api_url, api_data, api_token = null) => {
  try {
    return await axios.post(api_url, api_data, {
      headers: {
        Authorization: "token " + api_token,
      },
    });
  } catch (error) {
pages.Console("Error from Signup API", error);
  }
};
pages.getAPI = async (api_url) => {
  try {
    return await axios(api_url);
  } catch (error) {
pages.Console("Error from Linking (GET)", error);
  }
};

pages.load_login = () => {
    const login_btn = document.getElementById("login");
  const result = document.getElementById("response");

  const responseHandler = () => {
    result.innerHTML = '<div id = "response" class = "response_font"></div>';
  };

  const login = async () => {
    const login_url = base_url + "login.php";

    const login_data = new URLSearchParams();
    login_data.append("email", document.getElementById("email_login").value);
    login_data.append("password", document.getElementById("password_login").value);

    const response = await pages.postAPI(login_url, login_data);
    if (response.data.error) {
      result.innerHTML =
        '<div id = "response" class = "response_font">' +
        response.data.error +
        "</div>";
      setTimeout(responseHandler, 2000);
    } else {
      // Saving user data in the local storage
      const userData = [];
      const user_id = response.data.success.user_id;
      const first_name = response.data.success.first_name;
      const last_name = response.data.success.last_name;
      const email = response.data.success.email;

      userData.push({ user_id, first_name, last_name, email });
      localStorage.setItem("userData", JSON.stringify(userData));

      // Switching to the stream page
      window.location.href = "stream.html";
    }
  };
  login_btn.addEventListener("click", login);
};

pages.load_signup = () =>{

    const signup_btn = document.getElementById("signup");
    const result = document.getElementById("response");

    const responseHandler = () => {
        result.innerHTML = '<div id = "response" class = "response_font"></div>';
      };

    const signup = async () => {

        const signup_url = base_url + "signup.php";
    
        const signup_data = new URLSearchParams();
        signup_data.append("first_name", document.getElementById("first_name").value);
        signup_data.append("last_name", document.getElementById("last_name").value);
        signup_data.append("email", document.getElementById("email").value);
        signup_data.append("password", document.getElementById("password").value);
    
        const response = await pages.postAPI(
          signup_url,
          signup_data
        );
        if (response.data.error) {
          result.innerHTML =
            '<div id = "response" class = "response_font">' +
            response.data.error +
            "</div>";
          setTimeout(responseHandler, 2000);
        } else {
          result.innerHTML =
            '<div id = "response" class = "response_font">' +
            response.data.success +
            "<br>Now Login!</div>";
          setTimeout(responseHandler, 2000);
        }
      };
      signup_btn.addEventListener("click", signup);

};

pages.load_stream = async () => {
  const user = JSON.parse(localStorage.getItem("userData"));
  const user_id = user[0].user_id;
  const getImages = async () => {
    const get_images_url = base_url + "getImages.php?user_id=" + user_id;
    const response = await pages.getAPI(get_images_url);
    if (response.data.Error) {
      console.log(response.data.Error);
    } else {

      const images = response.data;
      let images_list =`<html>

      <head>
          <title>Stream page</title>
          <link rel="stylesheet" href="style.css">
          
      
      </head>
      
          <body>
      
              <!-- The navigation menu -->
      <div class="navbar">
          <a class="active">Home</a>
          <a href="#">Add image</a>
          <a href="#">Profile</a>
        </div>`;
      images.map(
        (image, i) =>
          (images_list += `<div class="card_stream">

          <div>
            <img class="img-placement" src="../Backend/Images/${image.url}" >
          </div>
          <div class="heart-placement comment-placement">
      
            <div>
      
              <img class = "heart_img" style="margin-right: 20px;" src="./empty_heart.png" width="25px" height="25px" />
      
            </div>
      
            <div>
      
              <img class="comment" style="margin-right: 10px;" src="./comment.png" width="25px" height="25px" />
      
            </div>
      
          </div>
      
          <div class="description-placement">
            <p>${image.description}</p>
          </div>
      
        </div>
      `)
      );
      images_list+=`<div class="comment-card comment-top" id ="add_comment">
      <div class="flex-row">
        <div class="x-icon" id="x_icon">
          <img src="./x_icon.png" width="20px" height="20px" />
        </div>
      </div>
      <textarea id = "comment_content" class="comment-area" rows="10" cols="5"></textarea>
      <form class="form">
        <input class="add-btn" id="add_btn" type="button" value="Add" />
      </form>
    </div>
    <script src="functionality.js" type="text/javascript"></script>
    </body>
  
  </html>`;
  document.write(images_list);
    }
}
getImages();


}