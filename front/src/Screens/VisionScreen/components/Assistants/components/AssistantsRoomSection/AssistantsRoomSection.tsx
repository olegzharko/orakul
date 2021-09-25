import React from 'react';
import { AssistantsWorkspaceStaff } from '../../types';

import AssistantRoomCard from '../AssistantRoomCard';

type AssistantsRoomSectionProps = {
  title: string;
  employees: AssistantsWorkspaceStaff[];
}

const AssistantsRoomSection = ({ title, employees }: AssistantsRoomSectionProps) => (
  <div className="room-section">
    <div className="room-section__header">
      <span>{title}</span>
    </div>
    <div className="room-section__body">
      {employees.map((employee) => (
        <AssistantRoomCard
          key={employee.full_name}
          color={employee.color}
          name={employee.full_name}
          startTime={employee.time}
          accompanying={`${employee.accompanying.ready}/${employee.accompanying.total}`}
          read={`${employee.read.ready}/${employee.read.total}`}
          generate={`${employee.generate.ready}/${employee.generate.total}`}
        />
      ))}
    </div>
  </div>
);

export default AssistantsRoomSection;
