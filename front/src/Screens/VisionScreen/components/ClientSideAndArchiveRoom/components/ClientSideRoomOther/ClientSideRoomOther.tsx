import React from 'react';

import { ClientSideRoomOther } from '../../types';

type ClientSideRoomOtherProps = {
  other?: ClientSideRoomOther[];
}

const ClientSideRoomOtherView = ({ other }: ClientSideRoomOtherProps) => {
  if (!other) return null;

  return (
    <div className="other vision-client-side-room__info-group">
      {other.map(({ title, info }) => (
        <div className="other__item" key={title}>
          <div className="title">
            <img src="/images/user.svg" alt="user" />
            <span>{title}</span>
          </div>
          <div className="info">
            {info.map((person) => (
              <span key={person.title}>{person.title}</span>
            ))}
          </div>
        </div>
      ))}
    </div>
  );
};

export default ClientSideRoomOtherView;
