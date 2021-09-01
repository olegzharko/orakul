import React from 'react';

const ClientSideRoomTime = () => (
  <div className="time">
    <div className="title">
      <img src="/images/clock.svg" alt="time" />
      <span>Час:</span>
    </div>
    <div className="vision-client-side-room__info-group">
      <span className="vision-client-side-room__title-text">
        Початок:
        <b>13:00</b>
      </span>
      <span className="vision-client-side-room__title-text">
        Середній час:
        <b>00:45</b>
      </span>
      <span className="vision-client-side-room__title-text">
        Загальний час:
        <b>00:52</b>
      </span>
      <span className="vision-client-side-room__title-text">
        Кількість клієнтів:
        <b>3</b>
      </span>
    </div>
  </div>
);

export default ClientSideRoomTime;
