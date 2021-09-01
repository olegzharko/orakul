import React from 'react';

const ClientSideRoomImmovables = () => (
  <div className="immovables">
    <div className="title">
      <img src="/images/navigation/immovable.svg" alt="immovable" />
      <span>Нерухомість:</span>
    </div>

    <div className="flex-column immovables__list">
      <span>вул. Ломоносова 40, кв. 101</span>
      <span>вул. Соборна 21, кв. 88</span>
    </div>
  </div>
);

export default ClientSideRoomImmovables;
