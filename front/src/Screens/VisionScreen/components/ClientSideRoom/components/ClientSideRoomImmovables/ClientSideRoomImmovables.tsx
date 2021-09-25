import React from 'react';
import { ClientSideRoomImmovable } from '../../types';

type ClientSideRoomImmovablesProp = {
  immovables: ClientSideRoomImmovable[];
}

const ClientSideRoomImmovables = ({ immovables }: ClientSideRoomImmovablesProp) => (
  <div className="immovables">
    <div className="title">
      <img src="/images/navigation/immovable.svg" alt="immovable" />
      <span>Нерухомість:</span>
    </div>

    <div className="flex-column immovables__list">
      {immovables.map(({ title }) => (
        <span key={title}>{title}</span>
      ))}
    </div>

  </div>
);

export default ClientSideRoomImmovables;
