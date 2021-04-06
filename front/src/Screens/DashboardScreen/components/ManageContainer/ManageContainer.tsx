import * as React from 'react';
import ContentPanel from '../../../../components/ContentPanel';
import Modal from '../../../../components/Modal';
import { useModal } from '../../../../components/Modal/useModal';
import Navigation from './components/Navigation';
import WorkSpace from './components/WorkSpace';
import { useManageContainer } from './useManageContainer';

const ManageContainer = () => {
  const meta = useManageContainer();
  const modalProps = useModal();

  return (
    <main className="manage df">
      <Navigation selected={meta.selectedNav} />
      <ContentPanel>
        <WorkSpace selectedNav={meta.selectedNav} />
      </ContentPanel>
      <Modal {...modalProps} />
    </main>
  );
};

export default ManageContainer;
