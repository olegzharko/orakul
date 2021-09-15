import React from 'react';

type AssistantRoomCardProps = {
  color: string;
  name: string;
  startTime: string;
  set: string;
  reading: string;
  issuance: string;
}

const AssistantRoomCard = ({
  color,
  name,
  startTime,
  set,
  reading,
  issuance,
}: AssistantRoomCardProps) => (
  <div
    className="employee"
  >
    <div
      className="employee__mark"
      style={{ backgroundColor: color }}
    />

    <div className="employee__main">
      <div className="employee__header">
        <img src="/images/user.svg" alt="user" />
        <span>{name}</span>
      </div>

      <div className="employee__body">
        <div className="indicator">
          <img src="/images/clock.svg" alt="clock" />
          <span>{startTime}</span>
        </div>

        <div className="indicator">
          <img src="/images/file.svg" alt="file" />
          <span>{set}</span>
        </div>

        <div className="indicator">
          <img src="/images/pencil.svg" alt="pencil" />
          <span>{reading}</span>
        </div>

        <div className="indicator">
          <img src="/images/table.svg" alt="table" />
          <span>{issuance}</span>
        </div>
      </div>
    </div>
  </div>
);

export default AssistantRoomCard;
