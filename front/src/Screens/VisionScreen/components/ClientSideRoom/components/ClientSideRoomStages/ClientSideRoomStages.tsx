import React from 'react';

const ClientSideRoomStages = () => (
  <div className="stages">
    <div className="title">
      <img src="/images/bar-chart.svg" alt="bar-chart" />
      <span>Етапи:</span>
    </div>
    <div className="stages__list">
      <span className="stages__stage stages__stage-success">
        Ознайомлюються з договором - 13:22
      </span>
      <span className="stages__stage stages__stage-success">
        Підготовка копій документів - 13:33
      </span>
      <span className="stages__stage stages__stage-success">
        Ознайомлення з документами забудовників - 13:39
      </span>
      <span className="stages__stage stages__stage-success">
        Оплата ноторівльних послуг - 13:44
      </span>
      <span className="stages__stage">
        Клієнти пішли в Банк
      </span>
      <span className="stages__stage">
        Очікують запрошуння до нотаріуса
      </span>
      <span className="stages__stage">
        Очікують оригінал Техпаспорту
      </span>
      <span className="stages__stage">
        Завершено
      </span>
    </div>
  </div>
);

export default ClientSideRoomStages;
