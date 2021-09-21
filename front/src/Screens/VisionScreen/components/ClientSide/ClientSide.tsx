import React from 'react';
import { VisionNavigationLinks } from '../../enums';

import './index.scss';

import WaitingRoomCard from './components/WaitingRoomClientCard';
import WaitingRoomGroupCard from './components/WaitingRoomGroupCard';
import WaitingRoomTable from './components/WaitingRoomTable';
import { useClientSide } from './useClientSide';
import Loader from '../../../../components/Loader/Loader';

const ClientSide = () => {
  const {
    isLoading,
    reception,
    meetingRooms,
    notaryRooms,
    emptyRoomClients,
  } = useClientSide();

  if (isLoading) return <Loader />;

  return (
    <div className="vision-client-side">
      <WaitingRoomTable clients={reception} />

      <div className="room-cards">
        {meetingRooms.map((room) => {
          if (room.client) {
            return (
              <WaitingRoomCard
                key={room.id}
                title={room.title}
                client={room.client}
              />
            );
          }

          return (
            <WaitingRoomGroupCard
              key={room.id}
              title={room.title}
              roomId={room.id}
              clients={emptyRoomClients}
            />
          );
        })}
      </div>
    </div>
  );
};

export default ClientSide;
