const FACTORY_PROCESS = 'process';

type Id = string | number;

enum FactoryRoutesParams {
  lineItemId = 'lineItemId',
  developerId = 'developerId',
  immovableId = 'immovableId',
  personId = 'personId',
  notaryId = 'notaryId',
  section = 'section',
}

enum FactoryLines {
  immovable = '/immovable'
}

enum Vision {
  clientSide = '/client-side',
  notary = '/notary',
  assistants = '/assistants',
  bank = '/bank',
  archive = '/archive',
  clientSideRoom = '/client-side/:id',
  archiveRoom = '/archive/:id',
}

export enum ImmovableFactoryLineSections {
  main = 'main',
  seller = 'seller',
  immovables = 'immovables',
  clients = 'clients',
  sideNotaries = 'side-notaries',
}

enum FactoryDashboardNavigation {
  set = '/',
  reading = '/read',
  accompanying = '/accompanying',
}

const factory = {
  immovableLine: `${FactoryLines.immovable}/:${FactoryRoutesParams.section}/:${FactoryRoutesParams.lineItemId}`,
  lineItemProcess: `/${FACTORY_PROCESS}/:processType/:lineItemId`,
};

const immovableFactoryLineSections = {
  main: `${FactoryLines.immovable}/${ImmovableFactoryLineSections.main}`,
  seller: `${FactoryLines.immovable}/${ImmovableFactoryLineSections.seller}`,
  immovables: `${FactoryLines.immovable}/${ImmovableFactoryLineSections.immovables}`,
  clients: `${FactoryLines.immovable}/${ImmovableFactoryLineSections.clients}`,
  sideNotaries: `${FactoryLines.immovable}/${ImmovableFactoryLineSections.sideNotaries}`,
};

const routes = {
  factory: {
    lines: {
      immovable: {
        path: factory.immovableLine,
        main: immovableFactoryLineSections.main,
        linkTo: (
          section: keyof typeof immovableFactoryLineSections,
          id: Id,
        ) => `${FactoryLines}/${section}/${id}`,
        exact: false,
        sections: {
          main: {
            path: `${immovableFactoryLineSections.main}/:${FactoryRoutesParams.lineItemId}`,
            base: immovableFactoryLineSections.main,
            linkTo: (lineItemId: Id) => `${immovableFactoryLineSections.main}/${lineItemId}`,
            exact: true,
          },
          seller: {
            path: `${immovableFactoryLineSections.seller}/:${FactoryRoutesParams.lineItemId}`,
            base: immovableFactoryLineSections.seller,
            linkTo: (lineItemId: Id) => `${immovableFactoryLineSections.seller}/${lineItemId}`,
            exact: false,
            developerView: {
              path: `${immovableFactoryLineSections.seller}/:${FactoryRoutesParams.lineItemId}/:${FactoryRoutesParams.developerId}`,
              linkTo: (lineItemId: Id, developerId: Id) => `${immovableFactoryLineSections.seller}/${lineItemId}/${developerId}`,
              exact: true,
            }
          },
          immovables: {
            path: `${immovableFactoryLineSections.immovables}/:${FactoryRoutesParams.lineItemId}`,
            base: immovableFactoryLineSections.immovables,
            linkTo: (lineItemId: Id) => `${immovableFactoryLineSections.immovables}/${lineItemId}`,
            exact: false,
            immovableView: {
              path: `${immovableFactoryLineSections.immovables}/:${FactoryRoutesParams.lineItemId}/:${FactoryRoutesParams.immovableId}`,
              linkTo: (lineItemId: Id, immovableId: Id) => `${immovableFactoryLineSections.immovables}/${lineItemId}/${immovableId}`,
              exact: true,
            },
            immovableCreate: {
              path: `${immovableFactoryLineSections.immovables}/:${FactoryRoutesParams.lineItemId}/create`,
              linkTo: (lineItemId: Id) => `${immovableFactoryLineSections.immovables}/${lineItemId}/create`,
              exact: true,
            },
          },
          clients: {
            path: `${immovableFactoryLineSections.clients}/:${FactoryRoutesParams.lineItemId}`,
            base: immovableFactoryLineSections.clients,
            linkTo: (lineItemId: Id) => `${immovableFactoryLineSections.clients}/${lineItemId}`,
            exact: false,
            clientView: {
              path: `${immovableFactoryLineSections.clients}/:${FactoryRoutesParams.lineItemId}/:${FactoryRoutesParams.personId}`,
              linkTo: (lineItemId: Id, clientId: Id) => `${immovableFactoryLineSections.clients}/${lineItemId}/${clientId}`,
              exact: true,
            },
            clientCreate: {
              path: `${immovableFactoryLineSections.clients}/:${FactoryRoutesParams.lineItemId}/:${FactoryRoutesParams.personId}`,
              linkTo: (lineItemId: Id) => `${immovableFactoryLineSections.clients}/${lineItemId}/create`,
              exact: true,
            },
          },
          sideNotaries: {
            path: `${immovableFactoryLineSections.sideNotaries}/:${FactoryRoutesParams.lineItemId}`,
            base: immovableFactoryLineSections.sideNotaries,
            linkTo: (lineItemId: Id) => `${immovableFactoryLineSections.sideNotaries}/${lineItemId}`,
            exact: true,
            view: {
              path: `${immovableFactoryLineSections.sideNotaries}/:${FactoryRoutesParams.lineItemId}/:${FactoryRoutesParams.notaryId}`,
              linkTo: (lineItemId: Id, notaryId: Id) => `${immovableFactoryLineSections.sideNotaries}/${lineItemId}/${notaryId}`,
              exact: true,
            },
            create: {
              path: `${immovableFactoryLineSections}/:${FactoryRoutesParams.lineItemId}/create`,
              linkTo: (lineItemId: Id) => `${immovableFactoryLineSections.sideNotaries}/${lineItemId}/create`,
              exact: true,
            }
          },
        }
      }
    },
    dashboard: {
      set: {
        path: FactoryDashboardNavigation.set,
        exact: true,
      },
      reading: {
        path: FactoryDashboardNavigation.reading,
        processBaseLink: `/${FACTORY_PROCESS}${FactoryDashboardNavigation.reading}`,
        exact: true,
      },
      accompanying: {
        path: FactoryDashboardNavigation.accompanying,
        processBaseLink: `/${FACTORY_PROCESS}${FactoryDashboardNavigation.accompanying}`,
        exact: true,
      }
    },
    processLineItem: {
      path: factory.lineItemProcess,
      linkTo: (processType: Id, lineItemId: Id) => `/${FACTORY_PROCESS}/${processType}/${lineItemId}`,
      exact: false,
      checkList: {
        path: `${factory.lineItemProcess}/checkList/:contractId`,
        linkTo: (processType: Id, lineItemId: Id, contractId: Id) => `/${FACTORY_PROCESS}/${processType}/${lineItemId}/checklist/${contractId}`,
        exact: true,
      }
    }
  },
  vision: {
    clientSide: {
      path: Vision.clientSide,
      linkTo: Vision.clientSide,
      exact: true,
    },
    notary: {
      path: Vision.notary,
      linkTo: Vision.notary,
      exact: true,
    },
    assistants: {
      path: Vision.assistants,
      linkTo: Vision.assistants,
      exact: true,
    },
    bank: {
      path: Vision.bank,
      linkTo: Vision.bank,
      exact: true,
    },
    archive: {
      path: Vision.archive,
      linkTo: Vision.archive,
      exact: true,
    },
    clientSideRoom: {
      path: Vision.clientSideRoom,
      linkTo: (roomId: Id) => `${Vision.clientSide}/${roomId}`,
      exact: true,
    },
    archiveRoom: {
      path: Vision.archiveRoom,
      linkTo: (roomId: Id) => `${Vision.archive}/${roomId}`,
      exact: true,
    }
  }
};

export default routes;
