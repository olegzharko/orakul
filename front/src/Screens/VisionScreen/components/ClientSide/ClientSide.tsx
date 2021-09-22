import React from 'react';

import Loader from '../../../../components/Loader/Loader';

import './index.scss';
import WaitingRoomCard from './components/WaitingRoomClientCard';
import WaitingRoomGroupCard from './components/WaitingRoomGroupCard';
import WaitingRoomTable from './components/WaitingRoomTable';
import { useClientSide } from './useClientSide';

const ClientSide = () => {
  const {
    isLoading,
    reception,
    meetingRooms,
    notaryRooms,
    emptyRoomClients,
    onReceptionClientFinish,
    onRoomClientToReception,
    onRoomClientFinish,
    onRoomClientToNotary,
    onNotaryClientToReception,
    onNotaryClientFinish,
  } = useClientSide();

  if (isLoading) return <Loader />;

  return (
    <div className="vision-client-side">
      <WaitingRoomTable
        clients={reception}
        onFinishClient={onReceptionClientFinish}
      />

      <div className="room-cards">
        {meetingRooms.map((room) => {
          if (room.client) {
            return (
              <WaitingRoomCard
                key={room.id}
                roomId={room.id}
                title={room.title}
                client={room.client}
                toReception={onRoomClientToReception}
                onFinish={onRoomClientFinish}
                toNotary={onRoomClientToNotary}
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

      <div className="vision-section-title">Нотаріуси</div>

      <div className="room-cards">
        {notaryRooms.map((room) => {
          if (room.client) {
            return (
              <WaitingRoomCard
                isNotary
                key={room.id}
                roomId={room.id}
                title={room.title}
                client={room.client}
                onFinish={onNotaryClientFinish}
                toReception={onNotaryClientToReception}
              />
            );
          }

          return (
            <WaitingRoomGroupCard
              isNotary
              key={room.id}
              title={room.title}
              roomId={room.id}
              notary_id={room.notary_id}
              clients={emptyRoomClients}
            />
          );
        })}
      </div>
    </div>
  );
};

export default ClientSide;
