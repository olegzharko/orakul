import React from 'react';

const ClientSideRoomCompleteSet = () => (
  <div className="complete-set">
    <div className="title">
      <img src="/images/codepen.svg" alt="codepen" />
      <span>Комплектація:</span>
    </div>

    <div className="vision-client-side-room__info-group complete-set__list">
      <span className="complete-set__item success">Вода</span>
      <span className="complete-set__item success">Пакети</span>
      <span className="complete-set__item success">Файли</span>
      <span className="complete-set__item success">Охайність</span>
      <span className="complete-set__item success">Папки</span>
      <span className="complete-set__item failed">Папки</span>
    </div>
  </div>
);

export default ClientSideRoomCompleteSet;
