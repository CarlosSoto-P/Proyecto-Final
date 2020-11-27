<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
  
    <title>Document</title>
    <link rel="stylesheet" href="css/stylemsg.css">
</head>
<body>
<div class='container' ng-cloak ng-app="chatApp">
  <h1>Swanky Chatbox UI With Angular</h1>
  <div class='chatbox' ng-controller="MessageCtrl as chatMessage">
    <div class='chatbox__user-list'>
      <h1>User list</h1>
      <div class='chatbox__user--active'>
        <p>Jack Thomson</p>
      </div>
      <div class='chatbox__user--busy'>
        <p>Angelina Jolie</p>
      </div>
      <div class='chatbox__user--active'>
        <p>George Clooney</p>
      </div>
      <div class='chatbox__user--active'>
        <p>Seth Rogen</p>
      </div>
      <div class='chatbox__user--away'>
        <p>John Lydon</p>
      </div>
    </div>
    <div class="chatbox__messages" ng-repeat="message in messages">
      <div class="chatbox__messages__user-message">
        <div class="chatbox__messages__user-message--ind-message">
          <p class="name">{{message.Name}}</p>
          <br />
          <p class="message">{{message.Message}}</p>
        </div>
      </div>
    </div>
    <form>
      <input type="text" placeholder="Enter your message">
    </form>
  </div>


    
</body>
</html>