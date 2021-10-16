import * as React from 'react';

import ContentPanel from '../../../../../components/ContentPanel';
import Modal from '../../../../../components/RequestModal';
import { useRequestModal } from '../../../../../components/RequestModal/useRequestModal';

import Navigation from './components/Navigation';
import WorkSpace from './components/WorkSpace';
import { useImmovableFactoryLine } from './useImmovableFactoryLine';

const ImmovableFactoryLine = () => {
  const meta = useImmovableFactoryLine();
  const modalProps = useRequestModal();

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

export default ImmovableFactoryLine;
