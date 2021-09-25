import React from 'react';

import Loader from '../../../../components/Loader/Loader';

import './index.scss';
import AssistantsRoomSection from './components/AssistantsRoomSection';
import { useAssistants } from './useAssistants';

const Assistants = () => {
  const {
    isLoading,
    workspace,
  } = useAssistants();

  if (isLoading) return <Loader />;

  return (
    <div className="vision-assistants">
      {workspace?.map(({ title, staff }) => (
        <AssistantsRoomSection
          key={title}
          title={title}
          employees={staff}
        />
      ))}
    </div>
  );
};

export default Assistants;
