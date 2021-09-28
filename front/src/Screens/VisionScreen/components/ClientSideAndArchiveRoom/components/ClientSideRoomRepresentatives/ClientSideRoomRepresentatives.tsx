import React from 'react';
import { ClientSideRoomRepresentative } from '../../types';

type ClientSideRoomRepresentativesProps = {
  representatives: ClientSideRoomRepresentative[]
};

const ClientSideRoomRepresentatives = ({ representatives }: ClientSideRoomRepresentativesProps) => (
  <div className="subscriber">
    <div className="title">
      <img src="/images/user.svg" alt="user" />
      <span>Підписант:</span>
    </div>
    <div className="vision-client-side-room__info-group">
      {representatives.map(({ title, value }) => (
        <span className="vision-client-side-room__title-text" key={title}>
          {title}
          :
          <b>{value}</b>
        </span>
      ))}
    </div>
  </div>
);

export default ClientSideRoomRepresentatives;
