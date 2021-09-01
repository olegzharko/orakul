import React from 'react';

const ClientSideRoomSubscriber = () => (
  <div className="subscriber">
    <div className="title">
      <img src="/images/user.svg" alt="user" />
      <span>Підписант:</span>
    </div>
    <div className="vision-client-side-room__info-group">
      <span className="vision-client-side-room__title-text">
        Статус:
        <b>Підписант в дорозі</b>
      </span>
      <span className="vision-client-side-room__title-text">
        Очікують:
        <b>2</b>
      </span>
      <span className="vision-client-side-room__title-text">
        ПІБ:
        <b>Дзюбук Руслан Миколайович</b>
      </span>
      <span className="vision-client-side-room__title-text">
        Залишилось:
        <b>0</b>
      </span>
      <span className="vision-client-side-room__title-text">
        Телефон:
        <b>+38 (093) 444 01 21</b>
      </span>
      <span className="vision-client-side-room__title-text">
        Примітка дня:
        <b>день народження</b>
      </span>
      <span className="vision-client-side-room__title-text">
        Підписав:
        <b>3</b>
      </span>
    </div>
  </div>
);

export default ClientSideRoomSubscriber;
