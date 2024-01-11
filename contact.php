<?php
include 'partials/header.php';
?>


    
<head>
<style>
    *, *:before, *:after {
  box-sizing: border-box;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
}

body {
  background-color: linear-gradient(to right, #ea1d6f 0%, #eb466b 100%);
  font-size: 12px;
  height: 100vh;
}

body, button, input {
  font-family: 'Montserrat', sans-serif;
  font-weight: 700;
  letter-spacing: 1.4px;
}

.background {
  display: flex;
  min-height: 100vh;
}

.container {
  flex: 0 1 700px;
  margin: auto;
  padding: 10px;
}
.logo h2{
  color: red;

}
.logo h5{
  color: grey;
  font-size: 0.8rem;
}
.logo hr{
  background-color: grey;
}
.logo span{
  color:white;
}

.screen {
  position: relative;
  background: #3e3e3e;
  border-radius: 15px;
}

.screen:after {
  content: '';
  display: block;
  position: absolute;
  top: 0;
  left: 20px;
  right: 20px;
  bottom: 0;
  border-radius: 15px;

  z-index: -1;
}

.screen-header {
  display: flex;
  align-items: center;
  padding: 10px 20px;

  background: #4d4d4f;
  border-top-left-radius: 15px;
  border-top-right-radius: 15px;
}

.screen-header-left {
  margin-right: auto;
}

.screen-header-button {
  display: inline-block;
  width: 8px;
  height: 8px;
  margin-right: 3px;
  border-radius: 8px;
  background: white;
}

.screen-header-button.close {
  background: #ed1c6f;
}

.screen-header-button.maximize {
  background: #e8e925;
}

.screen-header-button.minimize {
  background: #74c54f;
}

.screen-header-right {
  display: flex;
}

.screen-header-ellipsis {
  width: 3px;
  height: 3px;
  margin-left: 2px;
  border-radius: 8px;
  background: #999;
}

.screen-body {
  display: flex;
}

.screen-body-item {
  flex: 1;
  padding: 50px;
}

.screen-body-item.left {
  display: flex;
  flex-direction: column;
}

.app-title {
  display: flex;
  flex-direction: column;
  position: relative;
  color: #ea1d6f;
  font-size: 26px;
}

.app-title:after {
  content: '';
  display: block;
  position: absolute;
  left: 0;
  bottom: -10px;
  width: 25px;
  height: 4px;
  background: #ea1d6f;
}

.app-contact {
  margin-top: auto;
  font-size: 8px;
  color: #888;
}

.app-form-group {
  margin-bottom: 15px;
}

.app-form-group.message {
  margin-top: 40px;
}

.app-form-group.buttons {
  margin-bottom: 0;
  text-align: right;
}

.app-form-control {
  width: 100%;
  padding: 10px 0;
  background: none;
  border: none;
  border-bottom: 1px solid #666;
  color: #ddd;
  font-size: 14px;
  text-transform: uppercase;
  outline: none;
  transition: border-color .2s;
}

.app-form-control::placeholder {
  color: #666;
}

.app-form-control:focus {
  border-bottom-color: #ddd;
}

.app-form-button {
  background: none;
  border: none;
  color: #ea1d6f;
  font-size: 14px;
  cursor: pointer;
  outline: none;
}

.app-form-button:hover {
  color: #b9134f;
}

.credits {
  display: flex;
  justify-content: center;
  align-items: center;
  margin-top: 20px;
  color: red;
  font-family: 'Roboto Condensed', sans-serif;
  font-size: 16px;
  font-weight: normal;
}

.credits-link {
  display: flex;
  align-items: center;
  color: grey;
  font-weight: bold;
  text-decoration: none;
}

.dribbble {
  width: 20px;
  height: 20px;
  margin: 0 5px;
}


@media screen and (max-width: 700px) {
  .screen{
    padding: 1rem;
  }
}
@media screen and (max-width: 520px) {
  body{
    background: #3e3e3e;
  }
  .screen-body {
    flex-direction: column;
    padding: 1rem
  }
  .screen{
    padding: 1rem;
    margin-top: -250px;
    box-shadow: none;
    background: transparent;
  }

  .screen-body-item.left {
    margin-bottom: 30px;
  }

  .app-title {
    flex-direction: row;
  }

  .app-title span {
    margin-right: 12px;
  }

  .app-title:after {
    display: none;
  }
}

@media screen and (max-width: 600px) {
  .screen-body {
    padding: 40px;
  }

  .screen-body-item {
    padding: 0;
  }
}

</style>
</head>
<body>
  <div class="background">
    <div class="container">
      <div class="screen">
        <!-- ... existing HTML structure ... -->
        <div class="screen-body-item">
          <div class="logo">
            <h2>Adeke<span>Insights</span></h2><br>
            <h5>Contact Us:<br>
                Phone - +91 9096169545<br>
                Email - adekeinsights@gmail.com
            </h5>
            <hr>
          </div>
          <div class="app-form">
            <form id="contact-form" method="POST" action="process_form.php">
              <div class="app-form-group">
                <input class="app-form-control" type="text" name="name" placeholder="NAME" required>
              </div>
              <div class="app-form-group">
                <input class="app-form-control" type="email" name="email" placeholder="EMAIL" required>
              </div>
              <div class="app-form-group">
                <input class="app-form-control" type="tel" name="contact_no" placeholder="CONTACT NO" required>
              </div>
              <div class="app-form-group message">
                <textarea class="app-form-control" name="message" placeholder="MESSAGE" required></textarea>
              </div>
              <div class="app-form-group buttons">
                <button type="button" class="app-form-button" onclick="clearForm()">CANCEL</button>
                <button type="submit" class="app-form-button">SEND</button>
              </div>
            </form>
          </div>
        </div>
        <!-- ... existing HTML structure ... -->
      </div>
    </div>
  </div>
</body>