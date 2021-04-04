import * as React from 'react';
import ContentPanel from '../../../../components/ContentPanel';
import Navigation from './components/Navigation';
import WorkSpace from './components/WorkSpace';
import { useManageContainer } from './useManageContainer';

const ManageContainer = () => {
  const meta = useManageContainer();

  return (
    <main className="manage df">
      <Navigation selected={meta.selectedNav} />
      <ContentPanel>
        <WorkSpace selectedNav={meta.selectedNav} />
      </ContentPanel>
    </main>
  );
};

export default ManageContainer;
