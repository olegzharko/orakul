import * as React from 'react';
import Loader from '../../../../../../../../../../components/Loader/Loader';
import PrimaryButton from '../../../../../../../../../../components/PrimaryButton';
import SectionWithTitle from '../../../../../../../../../../components/SectionWithTitle';
import TitleInfoDuet from '../../../../../../../../../../components/TitleInfoDuet';
import { useGeneratorMain } from './useGeneratorMain';

const GeneratorMain = () => {
  const meta = useGeneratorMain();

  if (meta.isLoading) {
    return <Loader />;
  }

  return (
    <main className="main">
      <div className="dashboard-header section-title">{meta.title}</div>

      <SectionWithTitle title="Дані які не додані до договору ">
        <div className="grid">
          {meta.instructions.map(({ title, value }) => (
            <TitleInfoDuet title={title} info={value} />
          ))}
        </div>
      </SectionWithTitle>

      <div className="middle-button">
        <PrimaryButton label="Зберегти" onClick={meta.onSave} disabled={false} />
      </div>
    </main>
  );
};

export default GeneratorMain;
