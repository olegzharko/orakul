import React, { useEffect, useState } from 'react';
import { getWaitingTime } from '../../../../utils';

import { ClientSideRoomTime, ClientSideRoomTimeAliases } from '../../types';

type ClientSideRoomTimeProps = {
  time?: ClientSideRoomTime[];
}

const ClientSideRoomTimeView = ({ time }: ClientSideRoomTimeProps) => {
  const [waitingTime, setWaitingTime] = useState<string>('');

  useEffect(() => {
    const waitingTime = time?.find(({ alias }) => alias === ClientSideRoomTimeAliases.arrivalTime);
    setWaitingTime(getWaitingTime(waitingTime?.value!));
    setInterval(() => setWaitingTime(getWaitingTime(waitingTime?.value!)), 1000);
  }, [time]);

  if (!time) return null;

  return (
    <div className="time">
      <div className="title">
        <img src="/images/clock.svg" alt="time" />
        <span>Час:</span>
      </div>

      <div className="vision-client-side-room__info-group">
        {time.map(({ title, value, alias }) => (
          <span
            key={title}
            className="vision-client-side-room__title-text"
          >
            {title}
            <b>{alias === ClientSideRoomTimeAliases.waitingTime ? waitingTime : value}</b>
          </span>
        ))}
      </div>
    </div>
  );
};

export default ClientSideRoomTimeView;
